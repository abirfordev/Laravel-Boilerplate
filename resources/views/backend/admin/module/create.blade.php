<form id='create' action="" enctype="multipart/form-data" autocomplete="off" method="post" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="name">Module Name <span class="text-danger">*</span></label>
        <input id="name" class="form-control" type="text" name="name" required
            placeholder="Enter module name">
        <span id="error_name" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="name">URL</label>
        <input id="url" class="form-control" type="text" name="url" placeholder="Enter url">
        <span id="error_url" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="slug">Permission Slug <span class="text-danger">*</span></label>
        <input id="permission_slug" class="form-control" type="text" name="permission_slug" required
            placeholder="Enter permission slug">
        <span id="error_permission_slug" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 form-check my-1">
        <input id="is_children" class="form-check-input" type="checkbox" name="is_children" />
        <label class="form-check-label" for="is_children">
            Children
        </label>
        <span id="error_is_children" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 form-check my-1">
        <input id="is_label" class="form-check-input" type="checkbox" name="is_label" />
        <label class="form-check-label" for="is_label">
            Label
        </label>
        <span id="error_is_label" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-12 my-1 children_property" style="display:none">
        <label class="form-label" for="parent_module_id">Parent Module <span class="text-danger">*</span></label>
        <select id="parent_module_id" class="select2 form-select" name="parent_module_id">
            <option></option>
            @foreach ($modules as $parent_module)
                <option value="{{ $parent_module->id }}">{{ $parent_module->name }}
                </option>
            @endforeach
        </select>
        <span id="error_parent_module_id" class="text-danger error"></span>
    </div>


    <div class="col-12 my-1 text-end">
        <button type="reset" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-rotate-right me-1"></i>
            Clear
        </button>
        <button type="submit" class="btn btn-primary button-submit">
            <i class="fa-solid fa-floppy-disk me-1"></i>
            Save
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

        $('.button-submit').click(function() {
            // route name
            store_data('/admin/settings/module');
        });

    });
</script>
