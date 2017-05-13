$(document).ready(function () {
    $('#table_categories').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 10,
        "ajax": {
            "url": "dataCategories.php",
            "type": "POST"
        },
        "columns": [
            {"data": "urutan"},
            {"data": "name"},
            {"data": "button"},
        ]
    });


});
$(document).on("click", "#btnadd", function () {
    $("#modalCategories").modal("show");
    $("#txtname").focus();
    $("#txtname").val("");
    $("#crudmethod").val("N");
    $("#txtid").val("0");
});
$(document).on("click", ".btnhapus", function () {
    var category_id = $(this).attr("category_id");
    var name = $(this).attr("category_name");
    swal({
            title: "You are about to delete.",
            text: "Are you sure you want to delete the category: " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
        function () {
            var value = {
                category_id: category_id
            };
            $.ajax(
                {
                    url: "deleteCategory.php",
                    type: "POST",
                    data: value,
                    success: function (data, textStatus, jqXHR) {
                        var data = jQuery.parseJSON(data);
                        if (data.result == 1) {
                            $.notify('Successfully deleted ingredient');
                            var table = $('#table_categories').DataTable();
                            table.ajax.reload(null, false);
                        } else {
                            swal("Error", "Can't delete category, error : " + data.error, "error");
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error!", textStatus, "error");
                    }
                });
        });
});
$(document).on("click", "#btnsave", function () {
    var category_id = $("#txtid").val();
    var name = $("#txtname").val();
    var crud = $("#crudmethod").val();
     var regex = /^[a-zA-Z -]*$/;
    if (name == '' || name == null) {
        swal("Warning", "Shkruani emertimin e kategorise", "warning");
        $("#txtname").focus();
        return;
    }
    if (!(regex.test(name))) {
        swal("Warning", "Ne emertim te kategorise pranohen vetem germa te alfabetit!", "warning")
        $("#txtname").focus();
        return;
    }

    var value = {
        category_id: category_id,
        name: name,
        crud: crud
    };
    $.ajax(
        {
            url: "saveCategory.php",
            type: "POST",
            data: value,
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.crud == 'N') {
                    if (data.result == 1) {
                        $.notify('Successfully inserted data');
                        var table = $('#table_categories').DataTable();
                        table.ajax.reload(null, false);
                        $("#txtname").focus();
                        $("#txtname").val("");
                        $("#crudmethod").val("N");
                        $("#txtid").val("0");
                        $("#txtname").focus();
                    } else if (data.result == 2) {
                        swal("Error", "This category already exists, please choose another category name");
                    }

                    else {
                        swal("Error", "Can't save category data, error : " + data.error, "error");
                    }
                } else if (data.crud == 'E') {
                    if (data.result == 1) {
                        $.notify('Successfully updated data');
                        var table = $('#table_categories').DataTable();
                        table.ajax.reload(null, false);
                        $("#txtname").focus();
                    }

                    else {
                        swal("Error", "This category already exists, error : " + data.error, "error");
                    }
                } else {
                    swal("Error", "invalid order", "error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Error!", textStatus, "error");
            }
        });
});
$(document).on("click", ".btnedit", function () {
    var category_id = $(this).attr("category_id");
    var value = {
        category_id: category_id
    };
    $.ajax(
        {
            url: "getCategory.php",
            type: "POST",
            data: value,
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                $("#crudmethod").val("E");
                $("#txtid").val(data.category_id);
                $("#txtname").val(data.name);
                $("#modalCategories").modal('show');
                $("#txtname").focus();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Error!", textStatus, "error");
            }
        });
});
$.notifyDefaults({
    type: 'success',
    delay: 500
});