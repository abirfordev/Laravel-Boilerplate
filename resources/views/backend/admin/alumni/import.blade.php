<form id='create' action="" enctype="multipart/form-data" autocomplete="off" method="post" accept-charset="utf-8"
    class="row gx-3 gy-2 align-items-center needs-validation" novalidate>
    <div id="status"></div>

    <div class="col-12 col-md-12 my-1">
        <label class="form-label" for="alumni_file">Upload Excel or CSV file <span class="text-danger">*</span></label>
        <input id="alumni_file" class="form-control" type="file" name="alumni_file" required
            placeholder="Choose File" accept=".csv, .xls, .xlsx">
        <span id="error_alumni_file" class="text-danger error"></span>
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
            store_data('/admin/alumni/alumniImport');
        });

    });
</script>
