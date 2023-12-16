<form id='edit' action="" enctype="multipart/form-data" method="post" autocomplete="off" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>
    {{ method_field('PATCH') }}

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
        <input id="name" class="form-control" type="text" name="name" required value="{{ $user->name }}"
            placeholder="Enter name">
        <span id="error_name" class="text-danger error"></span>
    </div>
    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
        <input id="email" class="form-control" type="email" name="email" required value="{{ $user->email }}"
            placeholder="Enter email">
        <span id="error_email" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="mobile">Mobile No <span class="text-danger">*</span></label>
        <input id="mobile" class="form-control" type="text" name="mobile" required value="{{ $user->mobile }}"
            placeholder="Enter mobile no">
        <span id="error_mobile" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
        <div class="form-check">
            <div class="form-check form-check-inline">
                <input id="gender_male" class="form-check-input" type="radio" name="gender" value="Male"
                    {{ $user->gender === 'Male' ? 'checked' : '' }} />
                <label class="form-check-label" for="gender_male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="gender_female" class="form-check-input" type="radio" name="gender" value="Female"
                    {{ $user->gender === 'Female' ? 'checked' : '' }} />
                <label class="form-check-label" for="gender_female">Female</label>
            </div>
        </div>
        <span id="error_gender" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-6 my-1">
        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
        <div class="form-check">
            <div class="form-check form-check-inline">
                <input id="status_active" class="form-check-input" type="radio" name="status" value="1"
                    {{ $user->status == '1' ? 'checked' : '' }} />
                <label class="form-check-label" for="status_active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="status_inactive" class="form-check-input" type="radio" name="status" value="0"
                    {{ $user->status == '0' ? 'checked' : '' }} />
                <label class="form-check-label" for="status_inactive">Inactive</label>
            </div>
        </div>
        <span id="error_status" class="text-danger error"></span>
    </div>

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="image">Image</label>


        <div class="button-wrapper text-center">
            <img src="{{ asset($user->image) }}" alt="user image" class="rounded mb-2" height="200" width="200"
                id="image" />
            <br>
            <label for="upload" class="btn btn-outline-info btn-sm" tabindex="0">
                <span class="d-none d-sm-block">Change Image</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input id="upload" class="upload-image" type="file" name="image" hidden
                    accept=".jpg, .jpeg, .png, .webp" />
            </label>

            <p class="text-muted mb-0">Allowed jpg, jpeg, webp, png format image. Max size of 2MB</p>
        </div>

        <span id="error_image" class="text-danger error"></span>
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

<script type="text/javascript">
    (function() {

        // Update/reset user image of account page
        let accountUserImage = document.getElementById("image");
        const fileInput = document.querySelector(".upload-image"),
            resetFileInput = document.querySelector(".button-reset");

        if (accountUserImage) {
            const resetImage = accountUserImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    accountUserImage.src = window.URL.createObjectURL(
                        fileInput.files[0]
                    );
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = "";
                accountUserImage.src = resetImage;
            };
        }
    })();
</script>
<script>
    $(document).ready(function() {

        $('.button-update').click(function() {
            // route name and record id
            update_data('/admin/user', "{{ $user->id }}")
        });
    });
</script>
