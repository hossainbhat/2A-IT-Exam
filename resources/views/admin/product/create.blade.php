@extends('layouts.admin.app')
@section('title', 'Create Product')
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
                            <li class="breadcrumb-item active" aria-current="page">Product</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->

            <h6 class="mb-0 text-uppercase">Create New</h6>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form id="FormData">
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="form-group mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select id="category_id" name="category_id" class="form-select">
                                                <option selected="" @disabled(true)>Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="brand_id" class="form-label">Brand</label>
                                            <select id="brand_id" name="brand_id" class="form-select">
                                                <option selected="" @disabled(true)>Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="unit_id" class="form-label">Unit</label>
                                            <select id="unit_id" name="unit_id" class="form-select">
                                                <option selected="" @disabled(true)>Select Parent</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" placeholder="Enter name" value="{{ old('name') }}"
                                                id="name" name="name" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="product_code">Product Code <span class="text-danger">*</span></label>
                                            <input type="text" placeholder="Enter name" value="{{ old('product_code') }}"
                                                id="product_code" name="product_code" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group mt-3">
                                            <div class="mb-3">
                                                <label class="form-label d-block fw-bold">Status <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="statusActive" value="1" checked>
                                                    <label class="form-check-label" for="statusActive">Active</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="statusInactive" value="0">
                                                    <label class="form-check-label" for="statusInactive">Inactive</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group mt-3">
                                            <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('page_script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '#addBtn', function(e) {
                e.preventDefault();
                utlt.asyncFalseRequest('post', 'admin/product', '#FormData', null, 'admin/product');
            });
        });
    </script>
@endsection
