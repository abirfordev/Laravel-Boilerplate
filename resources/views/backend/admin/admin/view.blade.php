<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td> {{ $admin->name }} </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td> {{ $admin->email }} </td>
                </tr>
                <tr>
                    <th>Mobile No</th>
                    <td> {{ $admin->mobile }} </td>
                </tr>

                <tr>
                    <th>Roles</th>
                    <td>
                        @foreach ($admin->getRoleNames() as $role)
                            <span class="badge rounded-pill bg-info ">{{ $role }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $admin->gender }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>

                    <td><span
                            class="badge rounded-pill {{ $admin->status ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $admin->status ? 'Active' : 'Inactive' }}</span>
                    </td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td><img src="{{ asset($admin->image) }}" alt="image of {{ $admin->name }}" class="rounded"
                            height="100" width="100" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
