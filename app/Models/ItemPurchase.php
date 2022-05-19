<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPurchase extends Model
{
    use HasFactory;
    protected $table = 'item_purchases';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'order_purchase_id ',
        'purchase_id ',
        'item_id ',
        'item_batch_id ',
        'qty',
        'recieved',
        'discount',
        'price',
        'total',
    ];
}
