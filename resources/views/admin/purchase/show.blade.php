@extends('layouts.admin.app')
@section('title', 'Purchse Order Details')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Purchse Order Details</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->

            <h6 class="mb-0 text-uppercase">Purchse Order Details</h6>
            <hr>
            <div class="row">
                <div class="col-md-12">

                    <div class="container mt-4">
                        <div class="d-flex justify-content-end mb-3">
                            <button onclick="#" class="btn btn-primary">Print</button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong>Supplier: {{$purchase->supplier->name}}</strong>
                            </div>
                            <div class="col-4 text-center">
                                <strong>ORDER NO. {{$purchase->order_number}}</strong>
                            </div>
                            <div class="col-4 text-end">
                                <strong>DATE: {{ \Carbon\Carbon::parse($purchase->order_date)->format('d-m-Y') }}</strong>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Code</th>
                                    <th>Unit</th>
                                    <th>Pur. Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase->purchseOrderItem as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->product->brand->name}}</td>
                                    <td>{{$item->product->category->name}}</td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->product->product_code}}</td>
                                    <td>{{$item->product->unit->name}}</td>
                                    <td>{{$item->unit_price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->total_price}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7"></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$purchase->total_amount}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7"></td>
                                    <td><strong>Payment</strong></td>
                                    <td><strong>{{$purchase->paid_amount}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7"></td>
                                    <td><strong>Due</strong></td>
                                    <td><strong>{{$purchase->due_amount}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-4">
                                <strong>Warehouse</strong>
                            </div>
                            <div class="col-4 text-center">
                                <strong>Created By</strong>
                            </div>
                            <div class="col-4 text-end">
                                <strong>Checked By</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('page_script')

@endsection
