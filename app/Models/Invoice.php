<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'code',
        'agent_id',
        'user_id',
        'address_id',
        'delivering_date',
        'delivering_time',
        'user_address_id',
        'delivery_id',
        'agent_accepted_at',
        'delivery_accepted_at',
        'canceled_by',
        'canceled_at',
        'payment_type',
        'promocode_id',
        'is_charity',
        'status',
        'notes',
        'price',
        'delivery_price',
        'discount',
        'tax',
        'lat',
        'lng',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'agent_id' => 'integer',
        'user_id' => 'integer',
        'address_id' => 'integer',
        'delivering_date' => 'date',
        'user_address_id' => 'integer',
        'delivery_id' => 'integer',
        'agent_accepted_at' => 'timestamp',
        'delivery_accepted_at' => 'timestamp',
        'canceled_at' => 'timestamp',
        'promocode_id' => 'integer',
        'is_charity' => 'integer',
        'price' => 'decimal:6',
        'delivery_price' => 'decimal:6',
        'discount' => 'decimal:6',
        'tax' => 'decimal:6',
    ];


    public function invoiceProducts()
    {
        return $this->hasMany(\App\Models\InvoiceProduct::class)->with('product');
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function address()
    {
        return $this->belongsTo(\App\Models\Address::class);
    }

    public function userAddress()
    {
        return $this->belongsTo(\App\Models\UserAddress::class);
    }

    public function delivery()
    {
        return $this->belongsTo(\App\Models\Delivery::class);
    }

    public function promocode()
    {
        return $this->belongsTo(\App\Models\Promocode::class);
    }

    public function scopeOfStatus(Builder $builder, $status = null)
    {

        $builder->when($status, function (Builder $q) use ($status) {
            $q->where('status', $status);
        });
    }

    public function scopeStatistics(Builder  $builder):void
    {
        $builder->selectRaw('count(*)  as total')
            ->selectRaw("count(case when status = 'new' then 1 end) as new")
            ->selectRaw("count(case when status = 'delivery_approval' then 1 end) as delivery_approval")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when status = 'finished' then 1 end) as finished")
            ->selectRaw("count(case when status = 'canceled' then 1 end) as canceled")
          ;

    }

}
