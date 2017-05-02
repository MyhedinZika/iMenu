$(document).ready( function () 
    {
      $('#table_ingredients').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 10,
        "ajax": {
          "url": "data.php",
          "type": "POST"
        },
        "columns": [
        { "data": "urutan" },
        { "data": "i_name" },
        { "data": "button" },
        ]
      });


    });
    $(document).on("click","#btnadd",function(){
        $("#modalingredient").modal("show");
        $("#txtname").focus();
        $("#txtname").val("");
        $("#crudmethod").val("N");
        $("#txtid").val("0");
    });
    $(document).on( "click",".btnhapus", function() {
      var ingredient_id = $(this).attr("ingredient_id");
      var name = $(this).attr("name_cust");
      swal({   
        title: "You are about to delete.",   
        text: "Are you sure you want to delete the ingredient: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#3085d6", 
        cancelButtonColor: '#d33',  
        confirmButtonText: "Yes, Delete it!",   
        closeOnConfirm: true }, 
        function(){   
          var value = {
            ingredient_id: ingredient_id
          };
          $.ajax(
          {
            url : "deleteIngredient.php",
            type: "POST",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
              var data = jQuery.parseJSON(data);
              if(data.result ==1){
                $.notify('Successfully deleted ingredient');
                var table = $('#table_ingredients').DataTable(); 
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
      var ingredient_id = $("#txtid").val();
      var name = $("#txtname").val();
      var crud=$("#crudmethod").val();
      if(name == '' || name == null ){
        swal("Warning","Please fill customer name","warning");
        $("#txtname").focus();
        return;
      }
      var value = {
        ingredient_id: ingredient_id,
        name: name,
        crud: crud
      };
      $.ajax(
      {
        url : "saveIngredient.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          if(data.crud == 'N'){
            if(data.result == 1){
              $.notify('Successfully inserted data');
              var table = $('#table_ingredients').DataTable(); 
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
              var table = $('#table_ingredients').DataTable(); 
              table.ajax.reload( null, false );
              $("#txtname").focus();
            }else{
             swal("Error","Can't update customer data, error : "+data.error,"error");
            }
          }else{
            swal("Error","invalid order","error");
          }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
           swal("Error!", textStatus, "error");
        }
      });
    });
    $(document).on("click",".btnedit",function(){
      var ingredient_id=$(this).attr("ingredient_id");
      var value = {
        ingredient_id: ingredient_id
      };
      $.ajax(
      {
        url : "getIngredient.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#crudmethod").val("E");
          $("#txtid").val(data.ingredient_id);
          $("#txtname").val(data.i_name);
          $("#modalingredient").modal('show');
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