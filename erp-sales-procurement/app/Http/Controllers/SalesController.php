<?php
namespace App\Http\Controllers;
use App\Models\SalesRequest;
use App\Models\SalesRequestItem;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = SalesRequest::with(['items', 'creator'])->orderByDesc('created_at');
        if ($request->user()->role === 'sales') {
            $query->where('created_by', $request->user()->id);
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'     => 'required|string',
            'items'             => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.unit'      => 'required|string',
            'items.*.est_price' => 'nullable|numeric',
        ]);

        $sr = SalesRequest::create([
            'request_no'    => 'SR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
            'customer_name' => $request->customer_name,
            'notes'         => $request->notes,
            'status'        => 'submitted',
            'created_by'    => $request->user()->id,
        ]);

        foreach ($request->items as $item) {
            SalesRequestItem::create([
                'sales_request_id' => $sr->id,
                'item_name'        => $item['item_name'],
                'description'      => $item['description'] ?? null,
                'qty'              => $item['qty'],
                'unit'             => $item['unit'],
                'est_price'        => $item['est_price'] ?? 0,
            ]);
        }

        return response()->json($sr->load('items'), 201);
    }

    public function show($id)
    {
        return response()->json(
            SalesRequest::with(['items', 'creator', 'purchaseOrders'])->findOrFail($id)
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:submitted,approved,cancelled']);
        $sr = SalesRequest::findOrFail($id);
        $sr->update(['status' => $request->status]);
        return response()->json($sr);
    }

    public function destroy($id)
    {
        $sr = SalesRequest::findOrFail($id);
        if ($sr->status !== 'submitted') {
            return response()->json(['message' => 'Hanya SR dengan status submitted yang bisa dihapus'], 422);
        }
        $sr->delete();
        return response()->json(['message' => 'Sales Request berhasil dihapus']);
    }
}
