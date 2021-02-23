<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'product_id',
        'unit_price',
        'quantity',
        'total_price',
        'offer_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'invoice_id' => 'integer',
        'product_id' => 'integer',
        'unit_price' => 'decimal:6',
        'quantity' => 'integer',
        'total_price' => 'decimal:6',
        'offer_id' => 'integer',
    ];


    public function invoice()
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function offer()
    {
        return $this->belongsTo(\App\Models\Offer::class);
    }
}
