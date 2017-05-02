$(document).ready( function () 
    {
      $('#table_products').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 10,
        "ajax": {
          "url": "dataProducts.php",
          "type": "POST"
        },
        "columns": [
        { "data": "urutan" },
        { "data": "name" },
        { "data": "photo"},
        { "data": "categoryIdFK"},
        { "data": "button" },
        ]
      });


    });
    $(document).on("click","#btnadd",function(){
        $("#modalProducts").modal("show");
        $("#txtname").focus();
        $("#txtname").val("");
        $("#crudmethod").val("N");
        $("#txtid").val("0");
    });
    $(document).on( "click",".btnhapus", function() {
      var product_id = $(this).attr("product_id");
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
            product_id: product_id
          };
          $.ajax(
          {
            url : "deleteProduct.php",
            type: "POST",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
              var data = jQuery.parseJSON(data);
              if(data.result ==1){
                $.notify('Successfully deleted ingredient');
                var table = $('#table_products').DataTable(); 
                table.ajax.reload( null, false );
              }else{
                swal("Error","Can't delete product data, error : "+data.error,"error");
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
        swal("Warning","Please fill product name","warning");
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
        url : "saveProduct.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          if(data.crud == 'N'){
            if(data.result == 1){
              $.notify('Successfully inserted data');
              var table = $('#table_products').DataTable(); 
              table.ajax.reload( null, false );
              $("#txtname").focus();
              $("#txtname").val("");
              $("#crudmethod").val("N");
              $("#txtid").val("0");
              $("#txtname").focus();
            }else{
              swal("Error","Can't save product data, error : "+data.error,"error");
            }
          }else if(data.crud == 'E'){
            if(data.result == 1){
              $.notify('Successfully updated data');
              var table = $('#table_products').DataTable(); 
              table.ajax.reload( null, false );
              $("#txtname").focus();
            }else{
             swal("Error","Can't update product data, error : "+data.error,"error");
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
        url : "getProduct.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#crudmethod").val("E");
          $("#txtid").val(data.ingredient_id);
          $("#txtname").val(data.i_name);
          $("#modalProducts").modal('show');
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