<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPurchase extends Model
{
    use HasFactory;
    protected $table = 'order_purchases';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'type_id',
        'purchases_id',
        'reference_no',
        'user_id',
        'warehouse_id',
        'supplier_id',
        'item',
        'total_qty',
        'total_discount',
        'grand_total',
        'purchase_status',
        'payment_status',
        'desc',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Supplier::class, 'warehouse_id');
    }
}
