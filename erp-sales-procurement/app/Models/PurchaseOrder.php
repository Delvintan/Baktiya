<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = ['po_no', 'sales_request_id', 'supplier_name', 'total', 'status', 'expected_date', 'created_by'];

    public function items()        { return $this->hasMany(PurchaseOrderItem::class); }
    public function salesRequest() { return $this->belongsTo(SalesRequest::class); }
    public function creator()      { return $this->belongsTo(User::class, 'created_by'); }
}
