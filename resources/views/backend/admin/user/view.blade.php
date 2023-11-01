<div class="row">
    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td> {{ $user->name }} </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td> {{ $user->email }} </td>
                </tr>
                <tr>
                    <th>Mobile No</th>
                    <td> {{ $user->mobile }} </td>
                </tr>


                <tr>
                    <th>Gender</th>
                    <td>{{ $user->gender }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>

                    <td><span
                            class="badge rounded-pill {{ $user->status ? 'bg-label-success' : 'bg-label-danger' }} ">{{ $user->status ? 'Active' : 'Inactive' }}</span>
                    </td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td><img src="{{ asset($user->image) }}" alt="image of {{ $user->name }}" class="rounded"
                            height="100" width="100" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
