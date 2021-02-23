<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'precent',
        'price',
        'agent_id',
        'agent_product_id',
        'quantity',
        'start_at',
        'finish_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'price' => 'decimal',
        'agent_id' => 'integer',
        'agent_product_id' => 'integer',
        'start_at' => 'timestamp',
        'finish_at' => 'timestamp',
    ];


    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class);
    }

    public function agentProduct()
    {
        return $this->belongsTo(\App\Models\AgentProduct::class);
    }
}
