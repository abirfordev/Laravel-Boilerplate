<form id='edit' action="" enctype="multipart/form-data" method="post" autocomplete="off" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>
    {{ method_field('PATCH') }}

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="module_id">Module <span class="text-danger">*</span></label>
        <select id="module_id" class="select2 form-select" name="module_id" required>
            <option></option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}" {{ $module->id == $permission->module_id ? 'selected' : '' }}>
                    {{ $module->name }}
                </option>
            @endforeach
        </select>

        <span id="error_module_id" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="name">Permission Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter permission name"
            value="{{ $permission->name }}" required>
        <span id="error_name" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="label">Label <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="label" name="label" placeholder="Enter label"
            value="{{ $permission->label }}" required>
        <span id="error_label" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-4 form-check my-1">
        <input id="is_visibile_to_role" class="form-check-input" type="checkbox" name="is_visibile_to_role"
            {{ $permission->is_visibile_to_role ? 'checked' : '' }} />
        <label class="form-check-label" for="is_visibile_to_role">
            Visible to Role
        </label>
        <span id="error_is_visibile_to_role" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
        <div class="form-check">
            <div class="form-check form-check-inline">
                <input id="status_active" class="form-check-input" type="radio" name="status" value="1"
                    {{ $permission->status == '1' ? 'checked' : '' }} />
                <label class="form-check-label" for="status_active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="status_inactive" class="form-check-input" type="radio" name="status" value="0"
                    {{ $permission->status == '0' ? 'checked' : '' }} />
                <label class="form-check-label" for="status_inactive">Inactive</label>
            </div>
        </div>
        <span id="error_status" class="text-danger error"></span>
    </div>


    <div class="col-12 my-1 text-end">
        <button class="btn btn-secondary button-reset" type="reset">
            <i class="fa-solid fa-arrow-rotate-right me-1"></i>
            Reset
        </button>
        <button class="btn btn-primary button-update" type="submit">
            <i class="fa-solid fa-square-pen me-1"></i>
            Update
        </button>
    </div>

</form>

<script>
    $(document).ready(function() {

        $('.select2').select2({
            dropdownParent: $("#base_modal"),
            placeholder: 'Choose module',
            // allowClear: true
        });

        $('.button-update').click(function() {
            // route name and record id
            update_data('/admin/settings/permission', "{{ $permission->id }}")
        });
    });
</script>
