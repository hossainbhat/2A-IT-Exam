@extends('layouts.admin.app')
@section('title', 'Create Purchse Order')
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
                            <li class="breadcrumb-item active" aria-current="page">Purchse Order</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->

            <h6 class="mb-0 text-uppercase">Create New</h6>
            <hr>
            <div class="row">
                <div class="col-md-12">

                    <form id="FormData">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Product Row -->
                                        <div class="row mb-3">
                                            <div class="col-md-5">
                                                <label class="form-label">Product *</label>
                                                <select id="product" class="form-select">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            data-brand="{{ $product->brand->name }}"
                                                            data-category="{{ $product->category->name }}"
                                                            data-unit="{{ $product->unit->name }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Qty *</label>
                                                <input type="number" id="qty" class="form-control" placeholder="Qty">
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Unit Price *</label>
                                                <input type="number" id="unit_price" class="form-control"
                                                    placeholder="Unit Price">
                                            </div>

                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" id="addRow"
                                                    class="btn btn-primary w-100">+</button>
                                            </div>
                                        </div>

                                        <!-- Product Table -->
                                        <table class="table table-bordered" id="productTable">
                                            <thead>
                                                <tr>
                                                    <th>S/L</th>
                                                    <th>Item Details</th>
                                                    <th>Qty</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" class="text-end">Total</th>
                                                    <th id="totalQty">0</th>
                                                    <th></th>
                                                    <th id="totalPrice">0.00</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="d-flex justify-content-between">
                                            <button type="submit" id="addBtn" class="btn btn-success">Save</button>
                                            <a href="{{ route('purchase.index') }}" class="btn btn-danger">Cancel</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label class="form-label">Date *</label>
                                            <input type="date" id="order_date" name="order_date" class="form-control"
                                                value="{{ old('order_date') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Supplier</label>
                                            <select id="supplier_id" name="supplier_id" class="form-select">
                                                <option value="">Select Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Note</label>
                                            <input type="text" id="notes" name="notes" class="form-control"
                                                value="{{ old('notes') }}" placeholder="Write notes">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection
@section('page_script')
    <script>
        $(function() {
            let rowCount = 0;

            function updateTotals() {
                let totalQty = 0,
                    totalPrice = 0;
                $("#productTable tbody tr").each(function() {
                    const qty = parseFloat($(this).find(".row-qty").val()) || 0;
                    const price = parseFloat($(this).find(".row-price").val()) || 0;
                    const total = qty * price;

                    $(this).find(".row-total").text(total.toFixed(2));
                    totalQty += qty;
                    totalPrice += total;
                });
                $("#totalQty").text(totalQty);
                $("#totalPrice").text(totalPrice.toFixed(2));
            }

            // Add row
            $("#addRow").click(function() {
                const product = $("#product option:selected");
                const productId = product.val();
                const productName = product.text();
                const brand = product.data("brand");
                const category = product.data("category");
                const unit = product.data("unit");
                const qty = parseFloat($("#qty").val());
                const unitPrice = parseFloat($("#unit_price").val());

                if (!productId || !qty || !unitPrice) return alert(
                    'Please select product and fill qty/unit price.');

                const existingRow = $("#productTable tbody tr[data-id='" + productId + "']");
                if (existingRow.length) {
                    const oldQty = parseFloat(existingRow.find(".row-qty").val()) || 0;
                    existingRow.find(".row-qty").val(oldQty + qty);
                    existingRow.find(".row-price").val(unitPrice);
                } else {
                    rowCount++;
                    const row = `
                <tr data-id="${productId}">
                    <td>${rowCount}</td>
                    <td>Brand: ${brand} - Category: ${category} - ${productName} - ${unit}</td>
                    <td>
                        <input type="number" class="form-control row-qty" value="${qty}">
                        <input type="hidden" name="products[${rowCount}][product_id]" value="${productId}">
                        <input type="hidden" name="products[${rowCount}][quantity]" class="hidden-qty" value="${qty}">
                    </td>
                    <td>
                        <input type="number" class="form-control row-price" value="${unitPrice}">
                        <input type="hidden" name="products[${rowCount}][unit_price]" class="hidden-price" value="${unitPrice}">
                    </td>
                    <td class="row-total">${(qty * unitPrice).toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm deleteRow">🗑</button></td>
                </tr>
            `;
                    $("#productTable tbody").append(row);
                }

                updateTotals();
                $("#product, #qty, #unit_price").val('');
            });

            // Delete row
            $(document).on("click", ".deleteRow", function() {
                $(this).closest("tr").remove();
                updateTotals();
            });

            // Update totals on input change
            $(document).on("input", ".row-qty, .row-price", function() {
                updateTotals();
            });

            // Submit form\
            $(document).ready(function() {
                $(document).on('click', '#addBtn', function(e) {
                    e.preventDefault();
                    utlt.asyncFalseRequest('post', 'admin/purchase', '#FormData', null,
                        'admin/purchase');
                });
            });
        });
    </script>


@endsection
