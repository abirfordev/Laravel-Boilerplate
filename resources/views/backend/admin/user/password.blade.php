<form id='edit' action="" enctype="multipart/form-data" method="post" autocomplete="off" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>
    {{ method_field('PATCH') }}

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
        <input id="password" class="form-control" type="text" name="password" required
            placeholder="Enter mew password">
        <span id="error_password" class="text-danger error"></span>
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

        $('.button-update').click(function() {
            // route name and record id
            update_others_form('/admin/user/passwordUpdate', "{{ $user->id }}",
                "You want to change password!", "Yes, change it!")
        });
    });
</script>
