<form id='create' action="" enctype="multipart/form-data" autocomplete="off" method="post" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
        <input id="name" class="form-control" type="text" name="name" required placeholder="Enter name">
        <span id="error_name" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="label">label <span class="text-danger">*</span></label>
        <input id="label" class="form-control" type="text" name="label" required placeholder="Enter label">
        <span id="error_label" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="value">Value</label>
        <input id="value" class="form-control" type="text" name="value" placeholder="Enter value">
        <span id="error_value" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="instruction">Instruction</label>
        <textarea id="instruction" class="form-control" name="instruction" placeholder="Enter instruction"></textarea>
        <span id="error_instruction" class="text-danger error"></span>
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


        $('.button-submit').click(function() {
            // route name
            store_data('/admin/web-settings/setting');
        });

    });
</script>
