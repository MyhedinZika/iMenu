$(document).ready(function () {
    $('#table_size').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 10,
        "ajax": {
            "url": "dataSize.php",
            "type": "POST"
        },
        "columns": [
            {"data": "urutan"},
            {"data": "name"},
            {"data": "CategoryIDFK"},
            {"data": "button"},
        ]
    });


});
$(document).on("click", "#btnadd", function () {
    $("#modalSize").modal("show");
    $("#txtname").focus();
    $("#txtname").val("");
    $("#crudmethod").val("N");
    $("#txtid").val("0");
});
$(document).on("click", ".btnhapus", function () {
    var size_id = $(this).attr("size_id");
    var name = $(this).attr("size_name");
    swal({
            title: "You are about to delete.",
            text: "Are you sure you want to delete the size: " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true
        },
        function () {
            var value = {
                size_id: size_id
            };
            $.ajax(
                {
                    url: "deleteSize.php",
                    type: "POST",
                    data: value,
                    success: function (data, textStatus, jqXHR) {
                        var data = jQuery.parseJSON(data);
                        if (data.result == 1) {
                            $.notify('Successfully deleted size');
                            var table = $('#table_size').DataTable();
                            table.ajax.reload(null, false);
                        } else {
                            swal("Error", "Can't delete size data, error : " + data.error, "error");
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error!", textStatus, "error");
                    }
                });
        });
});
$(document).on("click", "#btnsave", function () {
    var size_id = $("#txtid").val();
    var name = $("#txtname").val();
    var category = $("#categoryIdFK").val();
    var crud = $("#crudmethod").val();
     var regex = /^[a-zA-Z -]*$/;
    if (name == '' || name == null) {
        swal("Warning", "Shkruani emertimin e size", "warning");
        $("#txtname").focus();
        return;
    }
    if (!(regex.test(name))) {
        swal("Warning", "Ne emertim te size pranohen vetem germa te alfabetit!", "warning")
        $("#txtname").focus();
        return;
    }
    var value = {
        size_id: size_id,
        name: name,
        categoryIDFK: category,
        crud: crud
    };
    $.ajax(
        {
            url: "saveSize.php",
            type: "POST",
            data: value,
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.crud == 'N') {
                    if (data.result == 1) {
                        $.notify('Successfully inserted data');
                        var table = $('#table_size').DataTable();
                        table.ajax.reload(null, false);
                        $("#txtname").focus();
                        $("#txtname").val("");
                        $("#crudmethod").val("N");
                        $("#txtid").val("0");
                        $("#txtname").focus();
                    } else {
                        swal("Error", "This size already exists, error : " + data.error, "error");
                    }
                } else if (data.crud == 'E') {
                    if (data.result == 1) {
                        $.notify('Successfully updated data');
                        var table = $('#table_size').DataTable();
                        table.ajax.reload(null, false);
                        $("#txtname").focus();
                    } else {
                        swal("Error", "This size already exists, error : " + data.error, "error");
                    }
                } else {
                    swal("Error", "invalid order", "Error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Error!", textStatus, "error");
            }
        });
});
$(document).on("click", ".btnedit", function () {
    var size_id = $(this).attr("size_id");
    var value = {
        size_id: size_id
    };
    $.ajax(
        {
            url: "getSize.php",
            type: "POST",
            data: value,
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                $("#crudmethod").val("E");
                $("#txtid").val(data.size_id);
                $("#txtname").val(data.name);
                // console.log(data.categoryIDFK);
//                 $('#categoryIdFK').on('onChange', function() {
//     console.log(data.categoryIDFK);
//     $('#categoryIdFK').dropdown('set selected',data.categoryIDFK);
// });
                // $('.ui.dropdown').dropdown('set selected', '0');
                 // $(".item").val(data.categoryIDFK);
                // console.log($('#categoryIdFK').dropdown('set selected',data.categoryIDFK));
                //$("#categoryIdFK").dropdown('set selected','data.categoryIDFK');
                $('#categoryIdFK').val(data.categoryIDFK);
                $("#modalSize").modal('show');
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