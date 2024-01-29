<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function orderTrans()
    {
        return $this->hasMany(OrderTransaction::class, 'item_order_id');
    }
}
