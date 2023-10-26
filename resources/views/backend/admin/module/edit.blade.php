<form id='edit' action="" enctype="multipart/form-data" method="post" autocomplete="off" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>
    {{ method_field('PATCH') }}

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="name">Module Name <span class="text-danger">*</span></label>
        <input id="name" class="form-control" type="text" name="name" required
            placeholder="Enter module name" value="{{ $module->name }}">
        <span id="error_name" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="name">URL</label>
        <input id="url" class="form-control" type="text" name="url" placeholder="Enter url"
            value="{{ $module->url }}">
        <span id="error_url" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="slug">Permission Slug <span class="text-danger">*</span></label>
        <input id="permission_slug" class="form-control" type="text" name="permission_slug" required
            placeholder="Enter permission slug" value="{{ $module->permission_slug }}">
        <span id="error_permission_slug" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-4 form-check my-1">
        <input id="is_children" class="form-check-input" type="checkbox" name="is_children"
            {{ $module->is_children ? 'checked' : '' }} />
        <label class="form-check-label" for="is_children">
            Children
        </label>
        <span id="error_is_children" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-4 form-check my-1">
        <input id="is_label" class="form-check-input" type="checkbox" name="is_label"
            {{ $module->is_label ? 'checked' : '' }} />
        <label class="form-check-label" for="is_label">
            Label
        </label>
        <span id="error_is_label" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-4 form-check my-1">
        <input id="is_visibile_to_role" class="form-check-input" type="checkbox" name="is_visibile_to_role"
            {{ $module->is_visibile_to_role ? 'checked' : '' }} />
        <label class="form-check-label" for="is_visibile_to_role">
            Visible to Role
        </label>
        <span id="error_is_visibile_to_role" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-12 my-1 children_property" style="{{ $module->is_children ? '' : 'display:none' }}">
        <label class="form-label" for="parent_module_id">Parent Module <span class="text-danger">*</span></label>
        <select id="parent_module_id" class="select2 form-select" name="parent_module_id">
            <option></option>
            @foreach ($modules as $parent_module)
                <option value="{{ $parent_module->id }}"
                    {{ $parent_module->id == $module->parent_module_id ? 'selected' : '' }}>
                    {{ $parent_module->name }}
                </option>
            @endforeach
        </select>
        <span id="error_parent_module_id" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
        <div class="form-check">
            <div class="form-check form-check-inline">
                <input id="status_active" class="form-check-input" type="radio" name="status" value="1"
                    {{ $module->status == '1' ? 'checked' : '' }} />
                <label class="form-check-label" for="status_active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="status_inactive" class="form-check-input" type="radio" name="status" value="0"
                    {{ $module->status == '0' ? 'checked' : '' }} />
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
            placeholder: 'Choose a parent module',
            // allowClear: true
        });

        $("#is_children").click(function() {
            if ($(this).is(":checked")) {
                $(".children_property").show();
            } else {
                $(".children_property").hide();
            }
        });

        $('.button-update').click(function() {
            // route name and record id
            update_data('/admin/settings/module', "{{ $module->id }}")
        });
    });
</script>
