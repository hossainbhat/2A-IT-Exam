@extends('layouts.admin.app')
@section('title', 'Category List')
@section('page_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
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
                            <li class="breadcrumb-item active" aria-current="page">Category</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->

            <h6 class="mb-0 text-uppercase">Category List</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="mb-2" style="float: right;">
                        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm"><i
                                class="fadeIn animated bx bx-plus-circle"></i>Add new</a>
                    </div>
                    <div class="">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap5">

                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="dataTable" class="table table-striped table-bordered dataTable"
                                        role="grid" aria-describedby="example2_info">

                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var dataTable = $('#dataTable').DataTable({
                dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"tr><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                buttons: [{
                    extend: 'excel',
                    text: "Excel Export",
                    attr: {
                        class: 'btn btn-info btn-sm'
                    },
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    filename: 'Category List'
                }],
                columns: [{
                        title: "SL",
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        'title': 'Name',
                        name: 'name',
                        data: "name"
                    },
                    {
                        'title': 'Parent',
                        data: "parent.name",
                        render: function(data, type, row, col) {
                            let returnData = '';

                            returnData += data ? data : 'Parent';

                            return returnData;
                        }
                    },
                    {
                        'title': 'Option',
                        data: 'id',
                        class: 'text-right width-5-per',
                        width: '10%',
                        render: function(data, type, row, col) {
                            let returnData = '';

                            returnData += '<a href="' + utlt.siteUrl('admin/category/' + data +
                                    '/edit') +
                                '"><i class="btn btn-sm btn-primary fadeIn animated bx bx-message-square-edit"></i></a> ';

                            returnData += '<a href="javascript:void(0);" data-val="' + data +
                                '" class="deleteItem"><i class="btn btn-danger btn-sm fadeIn animated bx bx-trash"></i></a>';

                            return returnData;
                        }
                    },
                ],

                ajax: {
                    url: utlt.siteUrl("admin/category"),
                },

                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                },
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: [0,2]
                }],
                responsive: true,
                autoWidth: false,
                serverSide: true,
                processing: true,
            });

            //delete
            $(document).on('click', '.deleteItem', function() {
                var $el = $(this);
                let config = Object.assign(utlt.swalConfig);
                Swal.fire(config).then(function(result) {
                    if (result.value === true) {
                        utlt.Delete('admin/category/' + $el.attr('data-val'), '#dataTable');
                    }
                });
            });

        });
    </script>
@endsection
