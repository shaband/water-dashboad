<?php

namespace App\Models;

use App\Traits\CanBlock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable
{
    use HasFactory,CanBlock;

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
        'car_number',
        'car_paper_image',
        'car_type_id',
        'city_id',
        'lat',
        'lng',
        'blocked_at',
        'status',
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
        'car_type_id' => 'integer',
        'city_id' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'blocked_at',
    ];


    public function carType()
    {
        return $this->belongsTo(\App\Models\CarType::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }



    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function scopeStatistics(Builder  $builder):void
    {
        $builder->selectRaw('count(*)  as total')
            ->selectRaw('count(case when blocked_at is null then 1 end) as active')
            ->selectRaw("count(case when blocked_at is Not Null then 1 end) as blocked");

    }

}
