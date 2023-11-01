<form id='create' action="" enctype="multipart/form-data" autocomplete="off" method="post" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
        <input id="name" class="form-control" type="text" name="name" required placeholder="Enter name">
        <span id="error_name" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
        <input id="email" class="form-control" type="email" name="email" required placeholder="Enter email">
        <span id="error_email" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="mobile">Mobile No <span class="text-danger">*</span></label>
        <input id="mobile" class="form-control" type="text" name="mobile" required placeholder="Enter mobile no">
        <span id="error_mobile" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
        <div class="form-check my-1">
            <div class="form-check form-check-inline">
                <input id="gender_male" class="form-check-input" type="radio" name="gender" value="Male" checked />
                <label class="form-check-label" for="gender_male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="gender_female" class="form-check-input" type="radio" name="gender" value="Female" />
                <label class="form-check-label" for="gender_female">Female</label>
            </div>
            <span id="error_gender" class="text-danger error"></span>
        </div>
        <span id="error_mobile" class="text-danger error"></span>
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
            store_data('/admin/user');
        });

    });
</script>
