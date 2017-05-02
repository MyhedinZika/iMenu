$(document).ready( function () 
    {
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
          "url": "dataUsers.php",
          "type": "POST"
        },
        "columns": [
        { "data": "urutan" },
        { "data": "Full_Name" },
        { "data" : "Email"},
        { "data" : "Phone"},
        { "data" : "isVerified"},
        { "data" : "userRole"},
        { "data": "button" },
        ]
      });


    });
    $(document).on("click","#btnadd",function(){
        $("#modalSize").modal("show");
        $("#txtname").focus();
        $("#txtname").val("");
        $("#crudmethod").val("N");
        $("#txtid").val("0");
    });
    $(document).on( "click",".btnhapus", function() {
      var user_id = $(this).attr("user_id");
      var name = $(this).attr("size_name");
      swal({   
        title: "You are about to delete.",   
        text: "Are you sure you want to delete the size: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#3085d6", 
        cancelButtonColor: '#d33',  
        confirmButtonText: "Yes, Delete it!",   
        closeOnConfirm: true }, 
        function(){   
          var value = {
            user_id: user_id
          };
          $.ajax(
          {
            url : "deleteUser.php",
            type: "POST",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
              var data = jQuery.parseJSON(data);
              if(data.result ==1){
                $.notify('Successfully deleted size');
                var table = $('#table_size').DataTable(); 
                table.ajax.reload( null, false );
              }else{
                swal("Error","Can't delete customer data, error : "+data.error,"error");
              }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
             swal("Error!", textStatus, "error");
            }
          });
        });
    });
    $(document).on("click","#btnsave",function(){
      var size_id = $("#txtid").val();
      var name = $("#txtname").val();
      var category = $("#categoryIdFK").val();
      var crud=$("#crudmethod").val();
      if(name == '' || name == null ){
        swal("Warning","Please fill customer name","warning");
        $("#txtname").focus();
        return;
      }
      var value = {
        size_id: size_id,
        name: name,
        categoryIDFK : category,
        crud: crud
      };
      $.ajax(
      {
        url : "saveSize.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          if(data.crud == 'N'){
            if(data.result == 1){
              $.notify('Successfully inserted data');
              var table = $('#table_size').DataTable(); 
              table.ajax.reload( null, false );
              $("#txtname").focus();
              $("#txtname").val("");
              $("#crudmethod").val("N");
              $("#txtid").val("0");
              $("#txtname").focus();
            }else{
              swal("Error","Can't save customer data, error : "+data.error,"error");
            }
          }else if(data.crud == 'E'){
            if(data.result == 1){
              $.notify('Successfully updated data');
              var table = $('#table_size').DataTable(); 
              table.ajax.reload( null, false );
              $("#txtname").focus();
            }else{
             swal("Error","Can't update customer data, error : "+data.error,"error");
            }
          }else{
            swal("Error","invalid order","Error");
          }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
           swal("Error!", textStatus, "error");
        }
      });
    });
    $(document).on("click",".btnedit",function(){
      var user_id=$(this).attr("user_id");
      var value = {
        user_id: user_id
      };
      $.ajax(
      {
        url : "getUser.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#crudmethod").val("E");
          $("#txtid").val(data.user_id);
          $("#txtname").val(data.Full_Name);
          $("#email").val(data.Email);
          $("#phone").val(data.Phone);
          $("#status").val(data.isVerified);
          $("#role").val(data.userRole);
          $("#modalSize").modal('show');
          $("#txtname").focus();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });
    $.notifyDefaults({
      type: 'success',
      delay: 500
    });