<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'reference_no',
        'order_purchase_id',
        'user_id',
        'warehouse_id',
        'supplier_id',
        'total_item',
        'total_qty',
        'total_recieved',
        'total_discount',
        'total_price',
        'order_discount',
        'grand_total',
        'paid_amount',
        'purchase_status',
        'payment_status',
        'send_date',
        'desc',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function order_purchase()
    {
        return $this->belongsTo(OrderPurchase::class, 'order_purchase_id');
    }
}
