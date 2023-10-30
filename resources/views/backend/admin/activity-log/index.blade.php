@extends('backend.admin.layout.master')
@section('title', 'Activity Log')
@section('nav-icon-title')
    <i class="fa-solid fa-person-military-pointing m-2"></i>
    <p class="m-0 p-0">Activity Log</p>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item active">Activity Log</li>
            </ol>
        </nav>
        <!--/ Breadcrumb -->

        <!-- DataTable with Buttons -->
        <div class="card">
            {{-- Export and Add new Button --}}
            {{-- <div class="d-flex flex-wrap justify-content-end mt-2">
                <div class="btn-group" id="dropdown-icon-demo">
                    <button type="button" class="btn rounded-pill btn-info dropdown-toggle mt-1 me-1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bxs-file-export me-1"></i>
                        <span class="d-none d-sm-block">Export</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-item">
                                Export all data
                            </a>
                        </li>
                        
                    </ul>
                </div>
                
            </div> --}}
            {{-- / Export and Add new Button --}}

            {{-- Table --}}
            <div class="card-datatable table-responsive mt-3">
                <table class="table border-top" id="base-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Type of User</th>
                            <th>Name of User</th>
                            <th>Log Name</th>
                            <th>Description</th>
                            <th>Date & time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $data)
                            <tr>
                                <td></td>
                                <td>{{ $key + 1 + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                                <td>{{ $data->causer->type }}</td>
                                <td>{{ $data->causer->name }}</td>
                                <td>{{ $data->log_name }}</td>
                                <td>{{ $data->causer->name . ' ' . $data->description }}</td>
                                <td>{{ $data->created_at }}</td>


                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{-- Info --}}
                <div class="d-flex justify-content-center m-3 text-muted">
                    @if (count($logs) > 0)
                        Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of
                        {{ $logs->total() }} entries
                    @endif
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $logs->links() !!}
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
                                    return 'Details of ' + data[1];
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


@endsection
