<?php
namespace App\Http\Controllers;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SalesRequest;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function index()
    {
        return response()->json(
            PurchaseOrder::with(['items', 'salesRequest', 'creator'])->orderByDesc('created_at')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name'     => 'required|string',
            'expected_date'     => 'required|date',
            'sales_request_id'  => 'nullable|exists:sales_requests,id',
            'items'             => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.unit'      => 'required|string',
            'items.*.price'     => 'required|numeric|min:0',
        ]);

        $total = collect($request->items)->sum(fn($i) => $i['qty'] * $i['price']);

        $po = PurchaseOrder::create([
            'po_no'            => 'PO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
            'sales_request_id' => $request->sales_request_id,
            'supplier_name'    => $request->supplier_name,
            'total'            => $total,
            'expected_date'    => $request->expected_date,
            'status'           => 'draft',
            'created_by'       => $request->user()->id,
        ]);

        foreach ($request->items as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'item_name'         => $item['item_name'],
                'qty'               => $item['qty'],
                'unit'              => $item['unit'],
                'price'             => $item['price'],
                'subtotal'          => $item['qty'] * $item['price'],
            ]);
        }

        if ($request->sales_request_id) {
            SalesRequest::findOrFail($request->sales_request_id)
                ->update(['status' => 'approved']);
        }

        return response()->json($po->load('items'), 201);
    }

    public function show($id)
    {
        return response()->json(
            PurchaseOrder::with(['items', 'salesRequest', 'creator'])->findOrFail($id)
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,confirmed,partial,received,cancelled',
        ]);
        $po = PurchaseOrder::findOrFail($id);
        $po->update(['status' => $request->status]);
        return response()->json($po);
    }

    public function salesRequests()
    {
        return response()->json(
            SalesRequest::with('items')->orderByDesc('created_at')->get()
        );
    }
}
