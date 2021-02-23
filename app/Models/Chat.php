<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_type',
        'second_type',
        'first_id',
        'second_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc')->with('sender');
    }

    public function first(): MorphTo
    {
        return $this->morphTo('first');
    }

    public function second(): MorphTo
    {
        return $this->morphTo('second');
    }

    public function last_message()
    {

        return $this->hasOne(Message::class, 'chat_id')->latest()->withDefault(new Message());
    }

    public function unseen_messages(): HasMany
    {
        /*dd(auth()->guard('admin')->user());*/
        $morphs = array_flip(Relation::morphMap());
      //  $model = $morphs[get_class(auth()->user())];
        return $this->hasMany(Message::class, 'chat_id')
            ->latest()
            ->where('seen_at', null)
            ->where('sender_id', '!=', auth()->id());
//          ->where('sender_type', '!=', $model);

    }

    public function scopeOfUser(Builder $builder, Authenticatable $user): void
    {
        $morphs = array_flip(Relation::morphMap());

        $builder->where(function (Builder $q) use ($user, $morphs) {

            $q->where('first_id', $user->id);
            $q->where('first_type', $morphs[get_class($user)]);
        });
        $builder->orWhere(function (Builder $q) use ($user, $morphs) {

            $q->where('second_id', $user->id);
            $q->where('second_type', $morphs[get_class($user)]);
        });
    }

    public function scopeBetweenUsers(Builder $builder, Authenticatable $first_user, Authenticatable $second_user): void
    {
        $builder->ofUser($first_user);
        $builder->ofUser($second_user);
        $builder->confirmMorphsInSameColumns($first_user, $second_user);
    }


    public function scopeWithOtherUser(Builder $q)
    {
        $morphs = array_flip(Relation::morphMap());
        $auth_type = $morphs[get_class(auth()->user())];
        $condition = "first_type='" . $auth_type . "' AND first_id=" . auth()->id();
        $q->addSelect(\DB::raw(
            "(CASE
                                WHEN " . $condition . " THEN  second_type
                                ELSE first_type END) as other_type "

        ));
        $q->addSelect(\DB::raw(
            "(CASE
                                WHEN " . $condition . " THEN  second_id
                                ELSE first_id END) as other_id"
        ));
    }

    /**
     * @param Builder $builder
     * @param Authenticatable $first_user
     * @param Authenticatable $second_user
     */
    public function scopeConfirmMorphsInSameColumns(Builder $builder, Authenticatable $first_user, Authenticatable $second_user): void
    {
        $morphs = array_flip(Relation::morphMap());
        $first_type = $morphs[get_class($first_user)];
        $second_type = $morphs[get_class($second_user)];

        $builder->whereRaw("
        CASE
            WHEN(`first_id` = ? and `first_type` = ?)
            THEN(`second_id` = ? and `second_type` = ?)
             ELSE (`first_id` = ? and `second_type` = ?)
        END",
            [
                $first_user->id, $first_type,
                $second_user->id, $second_type,
                $second_user->id, $second_type
            ]);
    }



    public function getOtherUserAttribute()
    {
        $morphs = array_flip(Relation::morphMap());


        if (
            $this->first_id == auth()->id()
            &&
            $this->first_model != $morphs[get_class(auth()->user())]
        ) {

            return $this->second;
        }

        return $this->first;

    }

}
