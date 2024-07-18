<!DOCTYPE html>
<html lang="en">
  <?php
  include "../object/database.php";
  include "../object/login.php";
  session_start();
  $e=empty($_SESSION["email"])?"":$_SESSION["email"];
  $image=empty($_SESSION["image"])?"":$_SESSION["image"];
  $userID=empty($_SESSION["userID"])?"":$_SESSION["userID"];


  $cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();  // Check if the cart exists in the session.
  $cartnumber = 0;  // Initialize a variable to hold the total price.
// Loop through the items in the cart and sum their prices.
foreach ($cartItems as $item) {
    $cartnumber += 1;
}


  if (isset($_GET['cName'])) {
    $cName = urldecode($_GET['cName']);  // Decode the URL parameter
} else {
    $cName="";
}

$Login = new Login("localhost", "user", "password", "finalproject");
  $category = [];
  $category = $Login->showCategory();

  $product = [];

  if(isset($_POST["search"]))
  {
    $women=empty($_POST["Women"])?"":$_POST["Women"];
    $men=empty($_POST["Men"])?"":$_POST["Men"];
    $children=empty($_POST["Children"])?"":$_POST["Children"];
    $red=empty($_POST["Red"])?"":$_POST["Red"];
    $green=empty($_POST["Green"])?"":$_POST["Green"];
    $blue=empty($_POST["Blue"])?"":$_POST["Blue"];
    $purple=empty($_POST["Purple"])?"":$_POST["Purple"];
    $white=empty($_POST["White"])?"":$_POST["White"];
    $black=empty($_POST["Black"])?"":$_POST["Black"];
    $yellow=empty($_POST["yellow"])?"":$_POST["yellow"];

    $product = $Login->showFilterProduct($women,$men,$children,$red,$green,$blue,$purple,$white,$black,$yellow);
  }
  else
  {
    $product = $Login->showCategoryProduct($cName);
  }
  if(isset($_POST["clear"]))
  {
    $product = $Login->showProduct();
  }
  
  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  </head>
  <body>
  <div class="site-wrap">
      <!--Start navigation-->
      <header class="site-navbar" role="banner">
        <div class="site-navbar-top">
            <div class="container">
                <div class="row align-items-center">
                
                <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                    <form action="searchProduct.php" method="POST" class="site-block-top-search">
                        <span class="icon icon-search2"></span>
                        <input type="text" name="title" class="form-control border-0" placeholder="Search">
                        <button type="submit" name="se" style="display: none;"></button>
                    </form>
                </div>

                    <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                        <div class="site-logo">
                        <a href="index.php" class="js-logo-clone">Azzstornish</a>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                        <div class="site-top-icons">
                            <ul>
                              <?php 
                              if(empty($e))
                              {
                              ?>
                                    <li><a href="login.php"><span class="icon icon-person" style="margin-right:10px;"></span></a></li>
                                <?php 
                              }
                              else
                              {
                                ?>
                              <li>
                              <a href="../User/profile.php">
                                    <img src="../Admin/image/user/<?php echo $image;?>" 
                                        class="user-image" 
                                        style="width:25px; margin-bottom:15px; height:25px; margin-right:3px;">
                                </a>
                              </li>                              
                              <li><a href="../Registration/logout.php"><span class="fa fa-sign-out fa-2x" aria-hidden="true" style="margin-right:-2px"></a></span></li>
                              <li><a href="../tetr.js/index.html"><span class="icon icon-game" style="margin-right:10px;">&#xf11b;</span></a></li>

                              <?php 
                              }?>

                                <li>
                                    <a href="cart.php" class="site-cart">
                                        <span class="icon icon-shopping_cart"></span>
                                        <span class="count"><?php echo $cartnumber;?></span>
                                    </a>
                                </li>
                                <li class="d-inline-block d-md-none ml-md-0"><a href="cart.php"
                                class="site-menu-toggle js-menu-toggle"><span
                                class="icon-menu"></span></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <nav class="site-navigation text-right text-md-center" role="navigation">
            <div class="container">
                <ul class="site-menu js-clone-nav d-none d-md-block">
                    <li>
                        <a href="index.php">Home</a>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <li class="active"><a href="shop.php">Shop</a></li>
                    <li><a href="cart.php">cart</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!--End navigation-->

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <div class="row">
              <div class="col-md-12 mb-5">
                <div class="float-md-left mb-4"><h2 class="text-black h5" style="margin-bottom: -40px">Shop All (<?php echo $cName;?>)</h2></div>

              </div>
            </div>

            <div class="row mb-5" >
            <?php
            if(count($product)>0)
            {
                foreach ($product as $product) {

                    ?>

                  <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                      <form method="POST" action="shop.php">
                          <div class="block-4 text-center border">
                                  <input type="hidden" name="pID" value="<?php echo $product['pID']?>">
                                  <input type="hidden" name="series" value="<?php echo $product['series']?>">
                                  <input type="hidden" name="color" value="<?php echo $product['color']?>">
                                  <input type="hidden" name="size" value="<?php echo $product['size']?>">
                                  <input type="hidden" name="category" value="<?php echo $product['category']?>">
                                  <input type="hidden" name="pName" value="<?php echo $product['pName']?>">


                              <figure class="block-4-image">
                                  <button type="submit" name="go" style="border: none; background: none;"><img src="../Admin/image/<?php echo $product["image"]?>" alt="Image placeholder" class="img-fluid image-zoom" style="width: 200px; height: 200px;">                            </button>

                              </figure>
                              <div class="block-4-text p-4">
                                  <h3>  <button type="submit" name="go" style="border: none; background: none; cursor: pointer; color:black;"><?php echo $product["pName"]?></button></h3>
                                  <p class="mb-0"><?php echo $product["series"]?></p>
                                  <p class="text-primary font-weight-bold"><?php echo $product["price"]?></p>
                              </div>
                              </form>
                          </div>
                      </div>

          <?php }}else
          {?>
                    <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up" >
                    <div class="block-4 text-center border">
                      <figure class="block-4-image">
                        <a href="index.php">
                          <img src="../Admin/image/ProductFound.png" alt="Image placeholder" class="img-fluid" >
                        </a>
                      </figure>
                      <div class="block-4-text p-4">
                        <h3><a href="index.php"></a></h3>
                        <p class="mb-0"></p>
                        <p class="text-primary font-weight-bold">Nothing To Show</p>
                      </div>
                    </div>
                  </div>
          <?php
        }?>

            </div>

          </div>

          <div class="col-md-3 order-1 mb-5 mb-md-0">
            <div class="border p-4 rounded mb-4">
            <form action="shop.php" method="POST">

            <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
        <ul class="list-unstyled mb-0">
            <li class="mb-1">
                <label>
                    <input type="checkbox" name="Men" value="Men"> Men <span class="text-black ml-auto"></span>
                </label>
            </li>
            <li class="mb-1">
                <label>
                    <input type="checkbox" name="Women" value="Women"> Women <span class="text-black ml-auto"></span>
                </label>
            </li>
            <li class="mb-1">
                <label>
                    <input type="checkbox" name="Children" value="Children"> Children <span class="text-black ml-auto"></span>
                </label>
            </li>
        </ul>



        <div class="mb-4">
            <h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>
            <label>
                <input type="checkbox" name="Red" value="Red"> Red
            </label>
            <label>
                <input type="checkbox" name="Green" value="Green"> Green 
            </label>
            <label>
                <input type="checkbox" name="Blue" value="Blue"> Blue 
            </label>
            <label>
                <input type="checkbox" name="Purple" value="Purple"> Purple
            </label>
            <label>
                <input type="checkbox" name="White" value="Blue"> White
            </label>
            <label>
                <input type="checkbox" name="Black" value="Black"> Black
            </label>
            <label>
                <input type="checkbox" name="yellow" value="Black"> Yellow
            </label>
        </div>

        <button type="submit" name="search" class="btn btn-primary rounded-pill mt-3">Search</button>
        <button type="submit" name="clear" class="btn btn-primary rounded-pill mt-3">Clear</button>

    </div>
    </div>

            </div>
          </div>
          </form>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>Categories</h2>
                  </div>
                </div>
                <div class="row">

                <?php
                    foreach ($category as $category) {
                      $cName = $category["cName"];

                      // Store the cName value in a session variable
                      $_SESSION['cName'] = $cName;
                      $cNameQueryParam = urlencode($cName);  // Ensure the value is properly URL-encoded
                      $link = "shopCategory.php?cName=$cNameQueryParam";
                      ?>
                      <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                          <a class="block-2-item" href="<?php echo $link; ?>">
                              <figure class="image">
                              <img src="../Admin/image/<?php echo $category["Image"] ?>" alt="" class="img-fluid" style="width: 700px; height: 500px;">
                              </figure>
                              <div class="text">
                                  <span class="text-uppercase">Collections</span>
                                  <h3><?php echo $cName ?></h3>
                              </div>
                          </a>
                      </div>
                      <?php
                    }
                    ?>

                </div>
              
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <footer class="site-footer border-top">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <h3 class="footer-heading mb-4">Promo</h3>
                    <a href="#" class="block-6">
                        <img src="images/hero_1.jpg" alt="Image placeholder" class="img-fluid rounded mb-4">
                        <h3 class="font-weight-light  mb-0">Finding Your Perfect Shoes</h3>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="block-5 mb-5">
                        <h3 class="footer-heading mb-4">Contact Info</h3>
                        <ul class="list-unstyled">
                            <li class="address">Sunway College Subang Jaya</li>
                            <li class="phone"><a href="tel://23923929210">+6011-33333333</a></li>
                            <li class="email">22029003@imail.sunway.edu.com <br>22018097@imail.sunway.edu.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row pt-5 mt-5 text-center">
                <div class="col-md-12">
                    <p>
                        Copyright &copy;<script data-cfasync="false"
                                                src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This Website is made with Perth and Zhiyun
                        
                    </p>
                </div>

            </div>
        </div>
    </footer>
</div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/add.js"></script>

  <script src="js/main.js"></script>
<!-- Include jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  </body>
</html>