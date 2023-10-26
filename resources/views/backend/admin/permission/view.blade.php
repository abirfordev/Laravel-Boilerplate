<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Module Name</th>
                    <td> {{ $permission->module->name }} </td>
                </tr>

                <tr>
                    <th>Permission Name</th>
                    <td> {{ $permission->name }} </td>
                </tr>

                <tr>
                    <th>Label</th>
                    <td> {{ $permission->label }} </td>
                </tr>

                <tr>
                    <th>Visible to Role</th>
                    <td>
                        <span
                            class="badge rounded-pill {{ $permission->is_visibile_to_role ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $permission->is_visibile_to_role ? 'Yes' : 'No' }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td><span
                            class="badge rounded-pill {{ $permission->status ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $permission->status ? 'Active' : 'Inactive' }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
