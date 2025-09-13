<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $products = new Product();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
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
                $search['name'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }


            $products = $products->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($products);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
        ]);
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
            ];
            Product::create($data);
            return sendSuccess('Successfully created !');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data['product'] = $product;
        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,'.$product->id,
        ]);
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
            ];
            $product->update($data);
            return sendSuccess('Successfully Update !');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return sendMessage('Successfully Delete');
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }
}
