<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesRequestItem extends Model
{
    protected $fillable = ['sales_request_id', 'item_name', 'description', 'qty', 'unit', 'est_price'];
    public function salesRequest() { return $this->belongsTo(SalesRequest::class); }
}
