<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'mark_id',
        'category_id',
        'provider_id',
        'is_charity',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mark_id' => 'integer',
        'category_id' => 'integer',
        'provider_id' => 'integer',
        'is_charity' => 'boolean',
    ];


    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function agentProducts()
    {
        return $this->hasMany(\App\Models\AgentProduct::class);
    }

    public function mark()
    {
        return $this->belongsTo(\App\Models\Mark::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(\App\Models\Provider::class);
    }
}
