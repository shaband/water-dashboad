<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'quantity',
        'product_id',
        'agent_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal',
        'quantity' => 'integer',
        'product_id' => 'integer',
        'agent_id' => 'integer',
    ];


    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class);
    }
}
