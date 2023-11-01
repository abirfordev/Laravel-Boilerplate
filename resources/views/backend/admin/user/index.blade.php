@extends('backend.admin.layout.master')
@section('title', 'User')
@section('nav-icon-title')
    <i class="fa-solid fa-user-gear m-2"></i>
    <p class="m-0 p-0">User</p>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item active">User</li>
            </ol>
        </nav>
        <!--/ Breadcrumb -->

        <!-- DataTable with Buttons -->
        <div class="card">
            {{-- Export and Add new Button --}}
            <div class="d-flex flex-wrap justify-content-end mt-2">
                @can('user_create')
                    <button class="btn rounded-pill btn-primary mt-1 me-1" type="button" onclick="create()">
                        <i class='bx bx-plus me-1'></i>
                        <span class="d-none d-sm-block">Add New Record</span>
                    </button>
                @endcan

                @can('user_trash')
                    <a href="{{ route('admin.user.trash') }}" class="btn rounded-pill btn-outline-danger mt-1 me-1">
                        <i class='bx bx-trash me-1'></i>
                        <span class="d-none d-sm-block">Trash</span>
                    </a>
                @endcan
            </div>
            {{-- / Export and Add new Button --}}

            <!--Search Form -->
            <div class="card-body">
                <form id="search_user" action="" method="GET">
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
                        @foreach ($users as $key => $data)
                            <tr>
                                <td></td>
                                <td>{{ $key + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
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

                                    <i {{ $can_read }} id="{{ $data->id }}" data-toggle="tooltip"
                                        class='bx bx-show text-primary view' title="View"></i>

                                    <i {{ $can_update }} id="{{ $data->id }}" data-toggle="tooltip"
                                        class='bx bx-edit text-success edit' title="Edit"></i>
                                    <i {{ $can_delete }} style="cursor: pointer;" id="{{ $data->id }}"
                                        data-toggle="tooltip" class='bx bx-trash text-warning delete' title="Delete"></i>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{-- Info --}}
                <div class="d-flex justify-content-center m-3 text-muted">
                    @if (count($users) > 0)
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                        {{ $users->total() }} entries
                    @endif
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $users->links() !!}
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
                            responsivePriority: 1,
                            targets: 2,
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
                                    return 'Details of ' + data[2];
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
        function create() {
            create_form_modal('/admin/user');
        }

        $(document).ready(function() {

            // View Form
            $("#base-table").on("click", ".view", function() {
                var id = $(this).attr('id');
                view_modal('/admin/user', id)
            });

            // Edit Form
            $("#base-table").on("click", ".edit", function() {
                var id = $(this).attr('id');
                edit_form_modal('/admin/user', id)
            });

            // Delete
            $("#base-table").on("click", ".delete", function() {
                var id = $(this).attr('id');
                soft_delete('/admin/user', id)
            });

        });
    </script>

@endsection
