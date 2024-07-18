<!DOCTYPE html>
<html lang="en">
  <?php 
  include "../object/database.php";
  include "../object/login.php";
  session_start();
  $e=empty($_SESSION["email"])?"":$_SESSION["email"];
  $image1=empty($_SESSION["image"])?"":$_SESSION["image"];
  $pID=empty($_SESSION["pID"])?"":$_SESSION["pID"];
  $color=empty($_SESSION["color"])?"":$_SESSION["color"];
  $series=empty($_SESSION["series"])?"":$_SESSION["series"];
  $size=empty($_SESSION["size"])?"":$_SESSION["size"];
  $userID=empty($_SESSION["userID"])?"":$_SESSION["userID"];
  $category1=empty($_SESSION["category"])?"":$_SESSION["category"];
  $pName=empty($_SESSION["pName"])?"":$_SESSION["pName"];


  $cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();  // Check if the cart exists in the session.
$cartnumber = 0;  // Initialize a variable to hold the total price.
// Loop through the items in the cart and sum their prices.
foreach ($cartItems as $item) {
    $cartnumber += 1;
}


  $Login = new Login("localhost", "user", "password", "finalproject");
  $category = [];
  $category = $Login->showCategory();
  $product= $Login->showDetailProduct($series,$color,$pName,$category1);
  $image= $Login->showDetailImageProduct($series,$category1,$pName);
  $chooseColor=$Login->showDetailColorProduct($series,$category1,$pName);
  $showSize=$Login->showSize($series,$color,$pName,$category1);
  $size1= $Login->showDetailQtyProduct($series,$color,$size,$pName);

  $number=0;


  if(isset($_POST["c"]))
  {
    $_SESSION["series"]=$_POST["series1"];
    $_SESSION["color"]=$_POST["color1"];
    $_SESSION["category"]=$_POST["category1"];
    $_SESSION["pName"]=$_POST["pName"];
    $_SESSION["size"]=$_POST["size"];

    header("location:shop-single.php");
  }

  if(isset($_POST["s"]))
  {
    $_SESSION["series"]=$_POST["series1"];
    $_SESSION["color"]=$_POST["color1"];
    $_SESSION["category"]=$_POST["category1"];
    $_SESSION["pName"]=$_POST["pName"];
    $_SESSION["size"]=$_POST["size"];

    header("location:shop-single.php");
  }

  if (isset($_POST["add"])) {
    
    if(!empty($e))
    {
      $pID = $_POST["pID"];
      $pName = $_POST["pName"];
      $image = $_POST["image"];
      $size = $_POST["size"];
      $price = $_POST["price"]; // Make sure to set the price
      $color = $_POST["color"];
      $finalQty = $_POST["finalQty"];
        if($finalQty==0)
        {

            echo "<script>
            alert('Please choose either a product quantity or a product that is not sold out. If the selected product is sold out, please choose another one.');
            window.location.href = 'shop.php';
            </script>"; 



        }else
        {
            $cartItem = array(
                "pID" => $pID,
                "pName" => $pName,
                "price" => $price, // Set the price
                "image" => $image,
                "size" => $size,
                "color" => $color,
                "finalQty" => $finalQty,
            );
            if (!isset($_SESSION["cart"])) {
                $_SESSION["cart"] = array();
            }
            $_SESSION["cart"][] = $cartItem;
            header("Location: cart.php");

        }
    }else
    {
    echo "<script>
    alert('Please sign in to the account before adding the product into cart');
    window.location.href = 'index.php';
    </script>";  
    }


}


  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

<style>
  button:hover {
    color: #ff0000; /* Change the color to your desired hover color */
  }


  .popup-container {
    display: none; /* Change 'flex' to 'none' */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: grey;
    z-index: 1;
    justify-content: center;
    align-items: center;
  }

/* Styles for the pop-up content */
.popup-content {
    background-color: white;
    border: 1px solid #ddd;
    padding: 20px;
    background-color: black;
    color: white;
    width: 80%;
    max-width: 800px;
    max-height: 80%;
    overflow: auto;
    position: relative;
}

.close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 24px;
    padding: 5px;
}

/* Adjusted styles for the navigation bar */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #333;
    color: white;
    padding: 10px;
    z-index: 2; /* Ensure it's above the popup */
}
table {
    border-collapse: collapse;
    width: 100%;
    color: white; /* Font color for the table */
}

th, td {
    border: 1px solid white; /* Border color for the table cells */
    padding: 8px;
    text-align: center;
}

th {
    background-color: #333; /* Header background color */
}


.btn-outline-primary {
    color: #000000; /* Change the text color to black */
    background-color: transparent;
    background-image: none;
    border-color: #000000; /* Change the border color to black */
}

.btn-outline-primary:hover {
    color: #fff;
    background-color: #000000; /* Change the background color to black on hover */
    border-color: #000000;
}

.btn-outline-primary.focus, .btn-outline-primary:focus {
    -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.5); /* Change the focus shadow color to black */
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.5);
}

.btn-outline-primary.disabled, .btn-outline-primary:disabled {
    color: #000000;
    background-color: transparent;
}

.btn-outline-primary:not(:disabled):not(.disabled).active,
.btn-outline-primary:not(:disabled):not(.disabled):active,
.show > .btn-outline-primary.dropdown-toggle {
    color: #fff;
    background-color: #000000; /* Change the background color to black when active */
    border-color: #000000;
}

.btn-outline-primary:not(:disabled):not(.disabled).active:focus,
.btn-outline-primary:not(:disabled):not(.disabled):active:focus,
.show > .btn-outline-primary.dropdown-toggle:focus {
    -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.5);
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.5);
}


</style>
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
                                    <img src="../Admin/image/user/<?php echo $image1;?>" 
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
                                <li class="d-inline-block d-md-none ml-md-0"><a href="#"
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
                    <li class="active">
                        <a href="index.php">Home</a>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="cart.php">cart</a></li>
                </ul>
            </div>
        </nav>
    </header>


    <!--End navigation-->

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><a href="shop.php">Product </a>/ <?php echo $product["pName"]?></strong></div>
        </div>
      </div>
    </div>  

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div id="product-image-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                      <div class="video-area">
                          <img src="https://images.template.net/wp-content/uploads/2015/09/15155625/Inspiring-Nike-Logos.jpg" alt="Image 1" />
                          <a href="<?php echo $product["video"]?>" class="popup-youtube">
                          <i class="fas fa-play-circle fa-3x"></i>
                          </a>
                      </div>
                  </div>
                <?php
                    foreach ($image as $image) {
                    $number+=1;
                ?>
                    <div class="carousel-item">
                         <img src="../Admin/image/<?php echo $image["image"]?>" alt="Image <?php echo $number;?>" class="d-block w-100 custom-carousel-image"  style=" width: 100px; height: 350px; " >
                    </div>

                <?php 
                    }
                ?>


                  </div>
                <a class="carousel-control-prev" href="#product-image-carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#product-image-carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" ></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
          
        </div>
     
        
        
        
          <div class="col-md-6">
          <h2 class="text-black"><b><?php echo $product["pName"] . " (" . $product["color"] . ")"; ?></b></h2>
          <h3 class="text-black"><?php echo $product["series"]?></h3>
          <h3 class="text-black"><?php echo $product["category"]?></h3>
          <h4 class="text-black"><?php echo $size?></h4>

            <p class="mb-4"><?php echo $product["details"]?></p>
            <p><strong class="text-primary h4">RM <?php echo $product["price"]?></strong></p>

            <div class="mb-1 d-flex">
              <label for="option-sm" class="d-flex mr-3 mb-3">
            <?php                     
            foreach ($chooseColor as $chooseColor) {
            ?>
            <form action="shop-single.php" method="POST">        
                <input type="hidden" name="color1" value="<?php echo $chooseColor['color']?>">
                <input type="hidden" name="series1" value="<?php echo $chooseColor['series']?>">
                <input type="hidden" name="category1" value="<?php echo $chooseColor['category']?>">
                <input type="hidden" name="pName" value="<?php echo $chooseColor['pName']?>">
                <input type="hidden" name="size" value="<?php echo $chooseColor['size']?>">

                <button name="c" class="custom-button"><?php echo $chooseColor['color']?></button>
            </form>
            <?php }?>
            </label>
            </div>
            <div style="display: flex; width: 100%;">
              <p style="flex: 1; width: 45%;">Select Size</p>
              <button style="flex: 1; width: 45%; background: none; border: none; cursor: pointer; transition: color 0.3s; color: black;" id="openPopup">
                Size Guidance
            </button>           
            </div>
            <div class="mb-1 d-flex">
              <label for="option-sm" class="d-flex mr-3 mb-3">
                      <?php
                      foreach ($showSize as $sizeOption) { // Use the same variable name ($sizeOption) in the loop
                      ?>
                      <form action="shop-single.php" method="POST">
                        <label>
                        <input type="hidden" name="color1" value="<?php echo $sizeOption['color']?>">
                        <input type="hidden" name="series1" value="<?php echo $sizeOption['series']?>">
                        <input type="hidden" name="category1" value="<?php echo $sizeOption['category']?>">
                        <input type="hidden" name="pName" value="<?php echo $sizeOption['pName']?>">
                        <input type="hidden" name="size" value="<?php echo $sizeOption['size']?>">


                        <button name="s" class="custom-button"><?php echo $sizeOption['size']?></button>
                        </label>
                      </form>
                      <?php
                      }
                      ?>
              </label>
          </div>

          <div class="popup-container" id="popupContainer">
        <div class="popup-content">
            <span class="close-button" id="closePopup">X</span>
            <h3>Shoe Size Conversion</h3>

            <table>
        <tr>
            <th>Category</th>
            <th>US</th>
            <th>UK</th>
            <th>EU</th>
        </tr>

        <tr>
            <td>Men</td>
            <td>7</td>
            <td>6</td>
            <td>40</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>7.5</td>
            <td>6.5</td>
            <td>41</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>8</td>
            <td>7</td>
            <td>42</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>8.5</td>
            <td>7.5</td>
            <td>42.5</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>9</td>
            <td>8</td>
            <td>43</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>9.5</td>
            <td>8.5</td>
            <td>44</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>10</td>
            <td>9</td>
            <td>44.5</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>10.5</td>
            <td>9.5</td>
            <td>45</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>11</td>
            <td>10</td>
            <td>46</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>11.5</td>
            <td>10.5</td>
            <td>46.5</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>12</td>
            <td>11</td>
            <td>47</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>12.5</td>
            <td>11.5</td>
            <td>47.5</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>13</td>
            <td>12</td>
            <td>48</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>13.5</td>
            <td>12.5</td>
            <td>49</td>
        </tr>
        <tr>
            <td>Men</td>
            <td>14</td>
            <td>13</td>
            <td>49.5</td>
        </tr>

        <tr>
            <td>Women</td>
            <td>5</td>
            <td>3</td>
            <td>35</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>5.5</td>
            <td>3.5</td>
            <td>36</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>6</td>
            <td>4</td>
            <td>36.5</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>6.5</td>
            <td>4.5</td>
            <td>37</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>7</td>
            <td>5</td>
            <td>38</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>7.5</td>
            <td>5.5</td>
            <td>38.5</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>8</td>
            <td>6</td>
            <td>39</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>8.5</td>
            <td>6.5</td>
            <td>40</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>9</td>
            <td>7</td>
            <td>40.5</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>9.5</td>
            <td>7.5</td>
            <td>41</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>10</td>
            <td>8</td>
            <td>42</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>10.5</td>
            <td>8.5</td>
            <td>42.5</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>11</td>
            <td>9</td>
            <td>43</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>11.5</td>
            <td>9.5</td>
            <td>44</td>
        </tr>
        <tr>
            <td>Women</td>
            <td>12</td>
            <td>10</td>
            <td>44.5</td>
        </tr>

        <tr>
            <td>Kids</td>
            <td>1</td>
            <td>0.5</td>
            <td>16</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>1.5</td>
            <td>1</td>
            <td>17</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>2</td>
            <td>1.5</td>
            <td>18</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>2.5</td>
            <td>2</td>
            <td>18.5</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>3</td>
            <td>2.5</td>
            <td>19</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>3.5</td>
            <td>3</td>
            <td>20</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>4</td>
            <td>3.5</td>
            <td>21</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>4.5</td>
            <td>4</td>
            <td>21.5</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>5</td>
            <td>4.5</td>
            <td>22</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>5.5</td>
            <td>5</td>
            <td>23</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>6</td>
            <td>5.5</td>
            <td>23.5</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>6.5</td>
            <td>6</td>
            <td>24</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>7</td>
            <td>6.5</td>
            <td>25</td>
        </tr>
        <tr>
            <td>Kids</td>
            <td>7.5</td>
            <td>7</td>
            <td>25.5</td>
        </tr>
    </table>
        </div>
    </div>

          <div class="mb-5">
            <form action="shop-single.php" method="POST">
              <div class="input-group mb-3" style="max-width: 120px;">
                <div class="input-group-prepend" >
                  <button class="btn btn-outline-primary"  type="button" onclick="decrementQuantity()">-</button>
                </div>
                <input id="quantityInput" type="number" name="finalQty" class="form-control text-center" value="0" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" readonly>
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" onclick="incrementQuantity()">+</button>
                </div>
              </div>
              <input type="hidden" name="pID" value="<?php echo $product['pID']?>">
              <input type="hidden" name="pName" value="<?php echo $product['pName']?>">
              <input type="hidden" name="image" value="<?php echo $product['image']?>">
              <input type="hidden" name="size" value="<?php echo $product['size']?>">
              <input type="hidden" name="price" value="<?php echo $product['price']?>">
              <input type="hidden" name="color" value="<?php echo $product['color']?>">

              <p class="text-danger">Hurry up! Only <?php echo $size1["qty"]?> left in stock.</p>
              <p>
                  <button name="add" class="buy-now btn btn-sm btn-primary" onclick="return confirm('Are you sure you want to add this item to your cart?')">Add To Cart</button>
              </p>
            </form>
          </div>
      </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Featured Products</h2>
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
                                  <img src="../Admin/image/<?php echo $category["Image"] ?>" alt="" class="img-fluid" style="width: 500px; height: 300px;">
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
  <script>
  function incrementQuantity() {
    var quantityInput = document.getElementById('quantityInput');
    var currentValue = parseInt(quantityInput.value);
    if (currentValue < <?php echo $size1["qty"]?>) {
      quantityInput.value = currentValue + 1;
    } else {
      alert("Quantity cannot exceed <?php echo $size1["qty"]?>.");
    }
  }
  
  function decrementQuantity() {
    var quantityInput = document.getElementById('quantityInput');
    var currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  }

  document.addEventListener("DOMContentLoaded", function() {
        const openButton = document.getElementById("openPopup");
        const closeButton = document.getElementById("closePopup");
        const popup = document.getElementById("popupContainer");

        openButton.addEventListener("click", () => {
            popup.style.display = "flex"; // Show the pop-up when the button is clicked
        });

        closeButton.addEventListener("click", () => {
            popup.style.display = "none"; // Close the pop-up when the close button is clicked
        });

        // Close the pop-up when clicking outside the content
        window.addEventListener("click", (event) => {
            if (event.target === popup) {
                popup.style.display = "none";
            }
        });
    });
</script>
  <script src="js/main.js"></script>
  <script src="js/add.js"></script>

  </body>
</html>