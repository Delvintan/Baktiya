<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesRequest extends Model
{
    protected $fillable = ['request_no', 'customer_name', 'notes', 'status', 'created_by'];

    public function items()         { return $this->hasMany(SalesRequestItem::class); }
    public function creator()       { return $this->belongsTo(User::class, 'created_by'); }
    public function purchaseOrders(){ return $this->hasMany(PurchaseOrder::class); }
}
