<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = ['purchase_order_id', 'item_name', 'qty', 'unit', 'price', 'subtotal'];
    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
}
