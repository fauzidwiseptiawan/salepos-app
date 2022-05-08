<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'type_id',
        'subtype_id',
        'brand_id',
        'unit_id',
        'supplier_id',
        'item_type',
        'item_code',
        'item_name',
        'sale_status',
        'barcode',
        'stock',
        'purchase_price',
        'selling_price',
        'rack',
        'is_batch',
        'promotion',
        'promotion_price',
        'start_date',
        'end_date',
        'minimum_stock',
        'desc',
        'image',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function subtype()
    {
        return $this->belongsTo(SubType::class, 'subtype_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}
