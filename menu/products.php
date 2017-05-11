<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iMenu</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- SweetAlert  style -->
    <link rel="stylesheet" href="../plugins/sweetalert/sweetalert.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <!-- responsive datatables -->
    <link rel="stylesheet" href="../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="../semantic/dist/semantic.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <?php
  include('header.php');


  $user = new SESSION();
  

  if (isset($_POST['action']) && $_POST['action'] == 'addProduct') {
    try {
      $name = $_POST['productName'];// name of pizza

      $imgFile = $_FILES['new-image']['name'];
      $tmp_dir = $_FILES['new-image']['tmp_name'];
      $imgSize = $_FILES['new-image']['size'];
      $category = $_POST['categoryIDFK'];
      $ingredients = $_POST['ingredients'];

      // $prices = $_POST['price'];

    if (empty($name)) {
      $errMSG = "Please Enter Username.";
    } else if (empty($imgFile)) {
      $errMSG = "Please Select Image File.";
    } else {
      $upload_dir = __DIR__ . '/product_images/'; // upload directory 

      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

      // valid image extensions
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

      // rename uploading image
      $userpic = rand(1000, 1000000) . "." . $imgExt;


      // allow valid image file formats
      if (in_array($imgExt, $valid_extensions)) {
        // Check file size '5MB'
        if ($imgSize < 5000000) {
          move_uploaded_file($tmp_dir, $upload_dir . $userpic);
        } else {
          $errMSG = "Sorry, your file is too large.";
        }
      } else {
        $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
    }
       

      if (!isset($errMSG)) {
        $user->addProduct($name,$userpic,$category);
      }

      $productId = $user->lastID();

      if (!isset($errMSG)) {
      foreach ($ingredients as $ingredientId) {
          $user->addProductIngredient($productId,$ingredientId);
      }
    }


      // if (!isset($errMSG)) {
      //   // $stmt = $database->connection->prepare('DELETE FROM pizza_ingredient WHERE pizza = :pizza');
      //   // $stmt->bindParam(':pizza', $pizzaId);

      //   // if (!$stmt->execute()) {
      //   //   // $errMSG = "error while deleting all pizza ingredients from pizza_ingredients";
      //   // }

      //   // foreach ($ingredients as $ingredient) {
      //   //   $stmt = $database->connection->prepare('INSERT INTO pizza_ingredient(pizza,ingredient) VALUES(:pizza,:ingredient)');
      //   //   $stmt->bindParam(':ingredient', $ingredient);
      //   //   $stmt->bindParam(':pizza', $pizzaId);

      //   //   if (!$stmt->execute()) {
      //   //     $errMSG = "error while inserting into pizza_ingredients";
      //   //   }
      //   // }
      // }


      // if (!isset($errMSG)) {
      //   $stmt = $database->connection->prepare('DELETE FROM pizza_size WHERE pizza = :pizza');
      //   $stmt->bindParam(':pizza', $pizzaId);

      //   if (!$stmt->execute()) {
      //     $errMSG = "error while deleting all pizza sizes from pizza_size";
      //   }


      //   foreach ($prices as $sizeId => $price) {
      //     $stmt = $database->connection->prepare('INSERT INTO pizza_size(pizza,size,price) VALUES(:pizza, :size, :price)');
      //     $stmt->bindParam(':pizza', $pizzaId);
      //     $stmt->bindParam(':size', $sizeId);
      //     $stmt->bindParam(':price', $price);

      //     if (!$stmt->execute()) {
      //       $errMSG = "error while inserting into pizza_size";
      //     }
      //   }
      // }


    } catch (Exception $e) {
      return $e->getMessage();
    }


  }
  ?>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <button type="submit" class="btn btn-primary " id="btnadd" name="btnadd"><i
                                    class="fa fa-plus"></i> Add Product
                        </button>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="table_products" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="tableheader">
                                <th style="width:80px">#</th>
                                <th style="width:300px">Name</th>
                                <th style="width:300px">Photo Source</th>
                                <th style="width:300px">Category</th>

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->

                    <!-- /.box-footer-->
                </div>
                <!-- /.box -->
                <form class="admin-form" method="post" enctype="multipart/form-data">
                    <div id="modalProducts" class="modal">

                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4 class="modal-title">Form Master Product</h4>
                                </div>
                                <!--modal header-->
                                <div class="modal-body">
                                    <div class="pad" id="infopanel"></div>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3  control-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtname" name="productName"
                                                       placeholder="Name">
                                                <input type="hidden" id="crudmethod" value="N">
                                                <input type="hidden" id="txtid" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label class="col-sm-3  control-label">Photo</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="new-image"
                                                       name="new-image"/>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3  control-label">Ingredients</label>
                                            <div class="col-sm-9">

                                                <select name="ingredients[]" class="ui fluid search dropdown"
                                                        multiple="" id="multi-select">
                                                    <option value="">Ingredients</option>
                                                  <?php
                                                  $ingredients = $user->getIngredients();
                                                  foreach ($ingredients as $key => $value) {
                                                    echo '<option value="' . $value['ingredientId'] . '">' . $value['i_name'] . '</option>';
                                                  }
                                                  ?>

                                                </select>
                                             
                                            
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-3  control-label">Category</label>
                                            <div class="col-sm-9">

                                                <select class="ui fluid search selection dropdown" id="categoryIdFK"
                                                        name="categoryIDFK">
                                                    <option value="">Category</option>
                                                  <?php

                                                  $user = new SESSION();
                                                  $categories = $user->getCategories();

                                                  foreach ($categories as $key => $value) {
                                                    echo '<option value="' . $value['categoryId'] . '">' . $value['name'] . '</option>';
                                                  }
                                                  ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-3  control-label"></label>
                                            <div class="col-sm-9">
                                                <button type="submit" class="btn btn-primary " id="btnsave"
                                                        name="action" value="addProduct"><i class="fa fa-save"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--modal footer-->
                                </div>
                                <!--modal-content-->
                            </div>
                            <!--modal-dialog modal-lg-->
                        </div>

                        <!--form-kantor-modal-->
                    </div>
                </form>
            </section>
            <!-- /.content -->
            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="container">


        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="container">


    </div>
    <!-- /.container -->
</footer>

<!-- Control Sidebar -->

<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>

<script>
    $('#multi-select')
        .dropdown()

    $('#categoryIdFK')
        .dropdown()
    ;
</script>
<!-- ./wrapper -->

<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- SweetAlert -->
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<!-- Bootstrap-notify -->
<script src="../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="products.js"></script>
</body>
</html>
