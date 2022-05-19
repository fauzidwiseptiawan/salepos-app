<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemWarehouse extends Model
{
    use HasFactory;
    protected $table = 'item_warehouse';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'item_id',
        'item_batch_id ',
        'warehouse_id ',
        'qty',
        'price'
    ];
}
