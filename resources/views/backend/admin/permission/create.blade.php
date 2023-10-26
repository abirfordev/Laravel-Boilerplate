<form id='create' action="" enctype="multipart/form-data" autocomplete="off" method="post" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>

    <div class="col-9 col-md-9 my-1">
        <label class="form-label" for="module_id">Module <span class="text-danger">*</span></label>
        <select id="module_id" class="select2 form-select" name="module_id[]" multiple="multiple" required>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}, {{ $module->permission_slug }}">{{ $module->name }}
                </option>
            @endforeach
        </select>

        <span id="error_module_id" class="text-danger error"></span>
    </div>

    <div class="col-3 col-md-3 form-check my-1 pt-4">
        <input class="form-check-input" type="checkbox" name="select_all" id="select_all" />
        <label class="form-check-label" for="select_all">
            Select all
        </label>
        <span id="error_select_all" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="name">Permission Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter permission name"
            required>
        <span id="error_name" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="label">Label <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="label" name="label" placeholder="Enter label" required>
        <span id="error_label" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-4 form-check my-1">
        <input id="is_visibile_to_role" class="form-check-input" type="checkbox" name="is_visibile_to_role" />
        <label class="form-check-label" for="is_visibile_to_role">
            Visible to Role
        </label>
        <span id="error_is_visibile_to_role" class="text-danger error"></span>
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
            placeholder: 'Choose module',

            // allowClear: true
        });

        $("#select_all").click(function() {
            if ($(this).is(":checked")) {
                $("#module_id > option").prop("selected", "selected");
                $("#module_id").trigger("change");
            } else {
                $("#module_id > option").prop("selected", false);
                $("#module_id").trigger("change");
            }
        });

        $('.button-submit').click(function() {
            // route name
            store_data('/admin/settings/permission');
        });

    });
</script>
