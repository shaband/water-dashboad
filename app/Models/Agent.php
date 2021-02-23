<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'email',
        'phone',
        'image',
        'blocked_at',
        'city_id',
        'lat',
        'lng',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'blocked_at' => 'timestamp',
        'city_id' => 'integer',
    ];


    public function deliveries()
    {
        return $this->belongsToMany(\App\Models\Delivery::class);
    }

    public function cities()
    {
        return $this->belongsToMany(\App\Models\City::class);
    }

    public function agentProducts()
    {
        return $this->hasMany(\App\Models\AgentProduct::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }


    public function scopeStatistics(Builder  $builder):void
    {
        $builder->selectRaw('count(*)  as total')
            ->selectRaw('count(case when blocked_at is null then 1 end) as active')
            ->selectRaw("count(case when blocked_at is Not Null then 1 end) as blocked");

    }

}
