<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
    ];

    public function customer(): Relation
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): Relation
    {
        return $this->belongsTo(Product::class);
    }
}
