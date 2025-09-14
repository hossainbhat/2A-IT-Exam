<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchseOrder;
use Illuminate\Http\Request;
use App\Models\PurchseOrderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $purchases = new PurchseOrder();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['supplier'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['order_number'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }


            $purchases = $purchases->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($purchases);
        }
        return view('admin.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['suppliers'] = Supplier::get();
        $data['products'] = Product::with(['unit', 'brand', 'category'])->get();
        return view('admin.purchase.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {
            $orderNumber = 'PO-' . now()->format('YmdHis');

            $purchaseOrder = PurchseOrder::create([
                'order_number' => $orderNumber,
                'order_date' => $request->order_date,
                'supplier_id' => $request->supplier_id,
                'total_amount' => 0,
                'paid_amount' => 0,
                'due_amount' => 0,
                'notes' => $request->notes,
            ]);

            $totalAmount = 0;
            foreach ($request->products as $item) {
                $totalPrice = $item['quantity'] * $item['unit_price'];
                $totalAmount += $totalPrice;

                PurchseOrderItem::create([
                    'purchse_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                ]);
            }

            $purchaseOrder->update([
                'total_amount' => $totalAmount,
                'due_amount' => $totalAmount,
            ]);
            DB::commit();
            return sendSuccess('Successfully created !');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }


    public function show(PurchseOrder $purchase)
    {
        $data['purchase'] = $purchase->load(['supplier', 'purchseOrderItem.product.unit', 'purchseOrderItem.product.brand', 'purchseOrderItem.product.category']);
        return view('admin.purchase.show',$data);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchseOrder $purchse)
    {
        try {
            $purchse->purchseOrderItem()->delete();
            $purchse->delete();
            return sendMessage('Successfully Delete');
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }
}
