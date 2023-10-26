<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Module Name</th>
                    <td> {{ $module->name }} </td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td> {{ $module->url }} </td>
                </tr>
                <tr>
                    <th>Permission Slug</th>
                    <td> {{ $module->permission_slug }} </td>

                </tr>
                <tr>
                    <th>Children</th>
                    <td>
                        <span
                            class="badge rounded-pill {{ $module->is_children ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $module->is_children ? 'Yes' : 'No' }}
                        </span>
                    </td>
                </tr>
                @if ($module->is_children && $module->parent_module_id != null)
                    <tr>
                        <th>Parent Module</th>
                        <td>{{ $module->parent->name }}
                        </td>
                    </tr>
                @endif

                <tr>
                    <th>Label</th>
                    <td>
                        <span
                            class="badge rounded-pill {{ $module->is_label ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $module->is_label ? 'Yes' : 'No' }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Status</th>

                    <td><span
                            class="badge rounded-pill {{ $module->status ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $module->status ? 'Active' : 'Inactive' }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
