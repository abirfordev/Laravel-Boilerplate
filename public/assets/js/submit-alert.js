// reload ajax table
// function reload_table() {
//     if (typeof table !== "undefined") {
//         table.ajax.reload(null, false); //reload datatable ajax
//     }
// }

/* RESTfull create form in modal*/

function create_form_modal(route) {
    $("#modal_data").empty();
    $(".modal-title").text("Add New"); // Set Title to Bootstrap modal title

    $.ajax({
        type: "GET",
        url: route + "/create",
        success: function (data) {
            $("#modal_data").html(data.html);
            $("#base_modal").modal("show"); // show bootstrap modal
        },
        error: function (result) {
            $("#modal_data").html("Sorry Cannot Load Data");
        },
    });
}

/* RESTfull store data*/

function store_data(route) {
    $("#status").html("");
    $(".error").empty();
    $("#create").validate({
        submitHandler: function (form) {
            var myData = new FormData($("#create")[0]);
            myData.append("_token", CSRF_TOKEN);

            let response = "";

            Swal.fire({
                title: "Are you sure?",
                text: "You want to submit!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, submit it!",
                showLoaderOnConfirm: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-success me-3",
                    cancelButton: "btn btn-secondary",
                },
                preConfirm: (t) =>
                    $.ajax({
                        url: route,
                        type: "POST",
                        data: myData,
                        dataType: "json",
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            response = data;
                        },
                    }),
                backdrop: !0,
                allowOutsideClick: () => !Swal.isLoading(),
            }).then(() => {
                if (response.type === "success") {
                    // window.location.href = "/admin/demo";
                    $("#create")[0].reset();
                    location.reload();
                    $("#base_modal").modal("hide");

                    Swal.fire({
                        icon: "success",
                        title: "That's Great!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 5000,
                    });
                } else if (response.type === "error") {
                    if (response.errors) {
                        $.each(response.errors, function (key, val) {
                            $("#error_" + key).html(val);
                        });
                    }
                    $("#status").html(response.message);
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Something going to wrong...",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            });
        },
    });
}

/* RESTfull view data in modal*/

function view_modal(route, id) {
    $("#modal_data").empty();
    $(".modal-title").text("View Details"); // Set Title to modal title

    $.ajax({
        url: route + "/" + id,
        type: "get",
        success: function (data) {
            $("#modal_data").html(data.html);
            $("#base_modal").modal("show"); // show modal
        },
        error: function (result) {
            $("#modal_data").html("Sorry Cannot Load Data");
        },
    });
}

/* RESTfull edit form in modal*/

function edit_form_modal(route, id) {
    $("#modal_data").empty();
    $(".modal-title").text("Edit data");

    $.ajax({
        url: route + "/" + id + "/edit",
        type: "get",
        success: function (data) {
            $("#modal_data").html(data.html);
            $("#base_modal").modal("show"); // show bootstrap modal
        },
        error: function (result) {
            $("#modal_data").html("Sorry Cannot Load Data");
        },
    });
}

/* RESTfull edit data*/

function update_data(route, id) {
    $("#status").html("");
    $(".error").empty();
    $("#edit").validate({
        submitHandler: function (form) {
            var myData = new FormData($("#edit")[0]);
            myData.append("_token", CSRF_TOKEN);

            let response = "";

            Swal.fire({
                title: "Are you sure?",
                text: "You want to update!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, update it!",
                showLoaderOnConfirm: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-info me-3",
                    cancelButton: "btn btn-secondary",
                },
                preConfirm: (t) =>
                    $.ajax({
                        url: route + "/" + id,
                        type: "POST",
                        data: myData,
                        dataType: "json",
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            response = data;
                        },
                    }),
                backdrop: !0,
                allowOutsideClick: () => !Swal.isLoading(),
            }).then(() => {
                if (response.type === "success") {
                    // window.location.href = "/admin/demo";
                    location.reload();
                    $("#base_modal").modal("hide");

                    Swal.fire({
                        icon: "success",
                        title: "That's Great!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 5000,
                    });
                } else if (response.type === "error") {
                    if (response.errors) {
                        $.each(response.errors, function (key, val) {
                            $("#error_" + key).html(val);
                        });
                    }
                    $("#status").html(response.message);
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Something going to wrong...",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            });
        },
    });
}

/* RESTfull delete data*/

function soft_delete(route, id) {
    let response = "";

    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        showLoaderOnConfirm: true,
        buttonsStyling: false,
        customClass: {
            confirmButton: "btn btn-warning me-3",
            cancelButton: "btn btn-secondary",
        },
        preConfirm: (t) =>
            $.ajax({
                url: route + "/" + id,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": CSRF_TOKEN,
                },
                dataType: "json",
                success: function (data) {
                    response = data;
                },
            }),

        backdrop: !0,
        allowOutsideClick: () => !Swal.isLoading(),
    }).then(() => {
        if (response.type === "success") {
            //window.location.href = "/admin/demo";

            location.reload();

            Swal.fire({
                icon: "success",
                title: "That's Great!",
                text: response.message,
                showConfirmButton: false,
                timer: 5000,
            });
        } else if (response.type === "error") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Deleting failed",
                showConfirmButton: false,
                timer: 2000,
            });
        }
    });
}

/* RESTfull restore trash data*/

function restore_single(route, id) {
    let response = "";

    Swal.fire({
        title: "Are you sure?",
        text: "You want to restore!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, restore it!",
        showLoaderOnConfirm: true,
        customClass: {
            confirmButton: "btn btn-primary me-3",
            cancelButton: "btn btn-label-secondary",
        },
        preConfirm: (t) =>
            $.ajax({
                url: route + "/" + id,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": CSRF_TOKEN,
                },
                dataType: "json",
                success: function (data) {
                    response = data;
                },
            }),

        backdrop: !0,
        allowOutsideClick: () => !Swal.isLoading(),
    }).then(() => {
        if (response.type === "success") {
            //window.location.href = "/admin/demo";

            location.reload();

            Swal.fire({
                icon: "success",
                title: "That's Great!",
                text: response.message,
                showConfirmButton: false,
                timer: 5000,
            });
        } else if (response.type === "error") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Restoring failed",
                showConfirmButton: false,
                timer: 2000,
            });
        }
    });
}

/* RESTfull restore selected trash data*/

function restore_selected(route, ids) {
    if (ids.length > 0) {
        let response = "";

        Swal.fire({
            title: "Are you sure?",
            text: "You want to restore selected data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, restore them!",
            showLoaderOnConfirm: true,
            customClass: {
                confirmButton: "btn btn-primary me-3",
                cancelButton: "btn btn-label-secondary",
            },
            preConfirm: (t) =>
                $.ajax({
                    url: route + "/" + ids,
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": CSRF_TOKEN,
                    },
                    dataType: "json",
                    success: function (data) {
                        response = data;
                    },
                }),

            backdrop: !0,
            allowOutsideClick: () => !Swal.isLoading(),
        }).then(() => {
            if (response.type === "success") {
                //window.location.href = "/admin/demo";

                location.reload();

                Swal.fire({
                    icon: "success",
                    title: "That's Great!",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 5000,
                });
            } else if (response.type === "error") {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Restoring failed",
                    showConfirmButton: false,
                    timer: 2000,
                });
            }
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No data is selected",
            customClass: { confirmButton: "btn btn-dark" },
            buttonsStyling: false,
        });
    }
}

/* RESTfull permanent delete trash data*/

function permanent_delete_single(route, id) {
    let response = "";

    Swal.fire({
        title: "Are you sure?",
        text: "You want to permanently remove!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, remove it!",
        showLoaderOnConfirm: true,
        buttonsStyling: false,
        customClass: {
            confirmButton: "btn btn-danger me-3",
            cancelButton: "btn btn-secondary",
        },
        preConfirm: (t) =>
            $.ajax({
                url: route + "/" + id,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": CSRF_TOKEN,
                },
                dataType: "json",
                success: function (data) {
                    response = data;
                },
            }),

        backdrop: !0,
        allowOutsideClick: () => !Swal.isLoading(),
    }).then(() => {
        if (response.type === "success") {
            //window.location.href = "/admin/demo";

            location.reload();

            Swal.fire({
                icon: "success",
                title: "That's Great!",
                text: response.message,
                showConfirmButton: false,
                timer: 5000,
            });
        } else if (response.type === "error") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Removing failed",
                showConfirmButton: false,
                timer: 2000,
            });
        }
    });
}

/* RESTfull permanent delete selected trash data*/

function permanent_delete_selected(route, ids) {
    if (ids.length > 0) {
        let response = "";

        Swal.fire({
            title: "Are you sure?",
            text: "You want to permanently remove selected data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, remove them!",
            showLoaderOnConfirm: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-danger me-3",
                cancelButton: "btn btn-secondary",
            },
            preConfirm: (t) =>
                $.ajax({
                    url: route + "/" + ids,
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": CSRF_TOKEN,
                    },
                    dataType: "json",
                    success: function (data) {
                        response = data;
                    },
                }),

            backdrop: !0,
            allowOutsideClick: () => !Swal.isLoading(),
        }).then(() => {
            if (response.type === "success") {
                //window.location.href = "/admin/demo";

                location.reload();

                Swal.fire({
                    icon: "success",
                    title: "That's Great!",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 5000,
                });
            } else if (response.type === "error") {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Removing failed",
                    showConfirmButton: false,
                    timer: 2000,
                });
            }
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No data is selected",
            customClass: { confirmButton: "btn btn-dark" },
            buttonsStyling: false,
        });
    }
}

/*

 * get district by division id

 */
// function get_district(division_id) {
//     $("#thana_id").empty();
//     $.ajax({
//         type: "GET",
//         url: "getDistrict/" + division_id,
//         success: function (data) {
//             $("#district_id").html(data);
//         },
//         error: function (result) {
//             $("#district_id").html("Sorry Cannot Load Data");
//         },
//     });
// }

/*

 * get thana by district id

 */

// function get_thana(district_id) {
//     $("#thana_id").empty();
//     $.ajax({
//         type: "GET",
//         url: "getThana/" + district_id,
//         success: function (data) {
//             $("#thana_id").html(data);
//         },
//         error: function (result) {
//             $("#thana_id").html("Sorry Cannot Load Data");
//         },
//     });
// }
