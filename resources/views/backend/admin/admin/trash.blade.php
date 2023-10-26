@extends('backend.admin.layout.master')
@section('title', 'Trash Admin')
@section('nav-icon-title')
    <i class="fa-solid fa-user-gear m-2"></i>
    <p class="m-0 p-0">Trash Admin</p>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-style2 mb-0">

                <li class="breadcrumb-item">
                    <a href="{{ route('admin.admin.index') }}">Admin</a>
                </li>
                <li class="breadcrumb-item active">Trash</li>
            </ol>
        </nav>
        <!--/ Breadcrumb -->



        <!-- DataTable with Buttons -->
        <div class="card">
            {{-- Restore and Remove Button --}}
            <div class="d-flex flex-wrap justify-content-end my-3">

                <button class="btn rounded-pill btn-primary restore_selected mt-1 me-1" type="button">
                    <i class='bx bxs-direction-left me-1'></i>
                    <span class="d-none d-sm-block">Restore Selected</span>
                </button>

                <button class="btn rounded-pill btn-outline-danger remove_selected mt-1 me-1" type="button">
                    <i class='fa-solid fa-ban me-1'></i>
                    <span class="d-none d-sm-block">Remove Selected</span>
                </button>


            </div>
            {{-- / Restore and Remove Button --}}

            <!--Search Form -->
            <div class="card-body">
                <form id="search_admin" action="" method="GET">
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-md-4">

                            <input type="text" class="form-control" placeholder="Type name" id="name" name="name"
                                @isset($name) value="{{ $name }}" @endisset>
                        </div>

                        <div class="col-12 col-md-4">

                            <input type="text" class="form-control" placeholder="Type email" id="email"
                                name="email" @isset($email) value="{{ $email }}" @endisset>
                        </div>


                        <div class="col-12 col-md-4">
                            <button id="clear" class="btn btn-outline-secondary" type="button"
                                onclick="clear_filter()">Clear</button>
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--/ Search Form -->


            {{-- Table --}}
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="base-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Image</th>
                            <th>gender</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $data)
                            <tr>
                                <td></td>
                                <td>{{ $data->id }}</td>
                                <td>
                                    {{ $key + 1 + ($admins->currentPage() - 1) * $admins->perPage() }}
                                    <input type="hidden" name="id" value="{{ $data->id }}" />
                                </td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->mobile }}</td>
                                <td>
                                    <div class="avatar avatar-md">
                                        <img src="{{ asset($data->image) }}" alt="Avatar"
                                            class="rounded img-fluid img-thumbnail">
                                    </div>
                                </td>
                                <td>{{ $data->gender }}</td>

                                <td><span
                                        class="badge rounded-pill {{ $data->status ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $data->status ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>
                                    <i style="cursor: pointer;" id="{{ $data->id }}" data-toggle="tooltip"
                                        class='bx bxs-direction-left text-primary restore' title="Restore"></i>
                                    <i style="cursor: pointer;" id="{{ $data->id }}" data-toggle="tooltip"
                                        class='fa-solid fa-ban text-danger permanentDelete' title="Permanent Delete"></i>

                                </td>


                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{-- Info --}}
                <div class="d-flex justify-content-center m-3 text-muted">
                    @if (count($admins) > 0)
                        Showing {{ $admins->firstItem() }} to {{ $admins->lastItem() }} of
                        {{ $admins->total() }} entries
                    @endif
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $admins->links() !!}
                </div>
            </div>
            {{-- / Table --}}

        </div>

    </div>


    <script>
        $(function() {
            'use strict';

            var dt_basic_table = $('#base-table');

            if (dt_basic_table.length) {
                var dt_basic = dt_basic_table.DataTable({
                    "lengthChange": false,
                    "paging": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,


                    columnDefs: [{
                            // For Responsive
                            className: 'control',
                            responsivePriority: 1,
                            targets: 0,
                            render: function(data, type, full, meta) {
                                return '';
                            }
                        },


                        {
                            targets: 1,

                            responsivePriority: 1,
                            // checkboxes: !0,
                            checkboxes: {
                                //selectRow: !0,
                                selectAllRender: '<input type="checkbox" class="form-check-input">',
                            },
                            render: function() {
                                return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                            },
                        },
                        {
                            responsivePriority: 1,
                            targets: 3,
                        },

                        {
                            responsivePriority: 1,
                            targets: -2,
                        },
                        {
                            responsivePriority: 1,
                            targets: -1,
                        },

                    ],

                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data[3];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !== '' ?
                                        '<tr data-dt-row="' +
                                        col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/><tbody />').append(data) : false;
                            }
                        }
                    },

                });

            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Restore
            $("#base-table").on("click", ".restore", function() {
                var id = $(this).attr('id');
                restore_single('/admin/settings/admin/restore', id)
            });

            // Permanent Delete
            $("#base-table").on("click", ".permanentDelete", function() {
                var id = $(this).attr('id');
                permanent_delete_single('/admin/settings/admin/permanentDelete', id)
            });


            // Restore selected
            $(".restore_selected").on("click", function() {
                var ids = [];

                $(".dt-checkboxes:checked").each(function() {
                    var id = $(this).parents('tr').find('input[name=id]').val();
                    ids.push(id);
                });

                restore_selected('/admin/settings/admin/restoreSelected', ids)
            });

            // Permanent Delete
            $(".remove_selected").on("click", function() {
                var ids = [];

                $(".dt-checkboxes:checked").each(function() {
                    var id = $(this).parents('tr').find('input[name=id]').val();
                    ids.push(id);
                });
                permanent_delete_selected('/admin/settings/admin/permanentDeleteSelected',
                    ids)
            });

        });
    </script>

@endsection
