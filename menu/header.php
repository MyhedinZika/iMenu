<?php
include '../includes/class.session.php';

$user = new SESSION();

if ($user->is_logged_in()) {
  $userId = $_SESSION['userSession'];
  $userInfo = $user->getUser($userId);

}


?>

<style>
    .navbar-nav li .dropdown-menu {
        margin-top: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        background-color: #3c8dbc;
    }

    .dropdown-menu li a {
        color: #fff;

    }

</style>

<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand"><b>i</b>Menu</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="products.php">Products</a></li>
                            <li class="divider"></li>
                            <li><a href="categories.php">Categories</a></li>
                            <li class="divider"></li>
                            <li><a href="ingredients.php">Ingredients</a></li>
                            <li class="divider"></li>
                            <li><a href="size.php">Size</a></li>
                            <!--  <li class="divider"></li> 
                              <li><a href="#">One more separated link</a></li> -->
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="users.php">Users</a></li>
                            <li class="divider"></li>
                            <li><a href="menu/categories.php">Test2</a></li>
                            <li class="divider"></li>
                            <li><a href="menu/ingredients.php">Test3</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Test4</a></li>
                            <!--  <li class="divider"></li> 
                              <li><a href="#">One more separated link</a></li> -->
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Raporte <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="menu/products.php">Test1</a></li>
                            <li class="divider"></li>
                            <li><a href="menu/categories.php">Test2</a></li>
                            <li class="divider"></li>
                            <li><a href="menu/ingredients.php">Test3</a></li>
                            <li class="divider"></li>
                            <li><a href="menu/size.php">Test4</a></li>
                            <!--  <li class="divider"></li> 
                              <li><a href="#">One more separated link</a></li> -->
                        </ul>
                    </li>
                </ul>
                <!--  <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                    </div>
                  </form> -->
            </div>
            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        </a>
                    </li>
                    <!-- /.messages-menu -->

                    <!-- Notifications Menu -->

                    <!-- Tasks Menu -->

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"> <?php echo $userInfo['Full_Name']; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>

                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!--     <li class="user-body">
                                   <div class="row">
                                     <div class="col-xs-4 text-center">
                                       <a href="#">Followers</a>
                                     </div>
                                     <div class="col-xs-4 text-center">
                                       <a href="#">Sales</a>
                                     </div>
                                     <div class="col-xs-4 text-center">
                                       <a href="#">Friends</a>
                                     </div>
                                   </div> 
                                 
                                 </li>   -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../pages/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>