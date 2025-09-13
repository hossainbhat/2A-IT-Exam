<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $suppliers = new Supplier();
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
                $search['email'] = $request->input('search')['value'];
                $search['mobile'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }


            $suppliers = $suppliers->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($suppliers);
        }
        return view('admin.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:11|unique:suppliers,mobile',
        ]);
        try {
            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'status' => $request->status,
            ];
            Supplier::create($data);
            return sendSuccess('Successfully created !');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $data['supplier'] = $supplier;
        return view('admin.supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:11|unique:suppliers,mobile,'.$supplier->id,
        ]);
        try {
            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'status' => $request->status,
            ];
            $supplier->update($data);
            return sendSuccess('Successfully Update !');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return sendMessage('Successfully Delete');
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }
}
