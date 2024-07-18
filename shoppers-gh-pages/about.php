<!DOCTYPE html>
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



$Login = new Login("localhost", "user", "password", "finalproject");
$category = [];
$category = $Login->showCategory();
$product = [];
$product = $Login->showTopProduct();
$register = new register("localhost", "user", "password", "finalproject");
if (isset($_POST["submit2"])) {

    $email = !empty($_POST["email"]) ? $_POST["email"] : "";
    $password = !empty($_POST["password"]) ? $_POST["password"] : "";
    $register->login($email, $password);

}

?>
<html lang="en">
  <head>
    <style>
      p{
        text-align: justify;
  text-justify: inter-word;
      }
      .play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-left: 20px solid transparent;
    border-right: 20px solid transparent;
    border-bottom: 30px solid #e74c3c; /* Your preferred background color */
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  /* Icon color */
  .play-button span {
    color: #fff; /* Your preferred icon color */
  }

  /* Hover effect */
  .play-button:hover {
    background-color: #c0392b; /* Change to a slightly different color on hover */
  }
      </style>
  
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />

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
                    <li >
                        <a href="index.php">Home</a>
                    <li class="active">
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
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">About</strong></div>
        </div>
      </div>
    </div>  

    <div class="site-section border-bottom" data-aos="fade">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-6">
        <div class="block-16">
          <figure>
            <img src="https://images.unsplash.com/photo-1612452830710-97cd38a7b6e8?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bmlrZSUyMGFpciUyMGpvcmRhbnxlbnwwfHwwfHx8MA%3D%3D" alt="Image placeholder" class="img-fluid rounded">
          </figure>
        </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-5">
            
            
            <div class="site-section-heading pt-3 mb-4">
              <h2 class="text-black">How We Started</h2>
            </div>
            <p>At Azzstornish, our journey began with a passion for bringing exceptional footwear to discerning customers. Founded 5 years ago by Gan Zhi Yun and Wong Loo Perth, our story is rooted in a commitment to quality, style, and customer satisfaction. What started as a vision to redefine the shoe-shopping experience has evolved into a thriving destination for fashion-forward individuals. From humble beginnings, we've grown into a brand that embodies innovation and trendsetting design. Our commitment to providing premium footwear and an unparalleled shopping experience remains unwavering, and we invite you to be a part of our story as we continue to step confidently into the future.</p>
                        
          </div>
        </div>
      </div>
    </div>

    <div class="site-section border-bottom" data-aos="fade">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 site-section-heading text-center pt-4">
        <h2>The Team</h2>
      </div>
    </div>
    <div class="row justify-content-center"> <!-- Center the entire row -->
      <div class="col-md-6 col-lg-3">
        <div class="block-38 text-center mx-auto">
          <div class="block-38-img">
            <div class="block-38-header">
              <img src="images/founder/perth.jpg" alt="Image placeholder" class="mb-4">
              <h3 class="block-38-heading h4">Wong Loo Perth</h3>
              <p class="block-38-subheading">CEO/Co-Founder</p>
            </div>
            <div class="block-38-body">
              <p>With a keen eye for innovation and a passion for excellence, Perth plays a pivotal role in steering the company towards success. His commitment to quality and customer satisfaction has been the driving force behind our growth. Under his leadership, Azzstornish continues to thrive as a symbol of style, comfort, and unwavering dedication to our valued customers.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="block-38 text-center mx-auto">
          <div class="block-38-img">
            <div class="block-38-header">
              <img src="images/founder/zhiyun.jpg" alt="Image placeholder" class="mb-4">
              <h3 class="block-38-heading h4">Gan Zhi Yun</h3>
              <p class="block-38-subheading">CIO/Co-Founder</p>
            </div>
            <div class="block-38-body">
              <p>As the CIO and Co-Founder of Azzstornish, Gan Zhi Yun is the technological visionary driving our digital landscape. With a strategic mindset and a deep understanding of information technology, Zhi Yun shapes and oversees our company's digital strategy. His innovative approach ensures that Azzstornish remains at the forefront of technological advancements, providing our customers with a seamless and cutting-edge experience. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    </div>
    </div>
  </div>
</div>
</div>
</div>
  

    <div class="site-section site-section-sm site-blocks-1 border-0" data-aos="fade">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
            <div class="icon mr-4 align-self-start">
              <span class="icon-truck"></span>
            </div>
            <div class="text">
                <h2 class="text-uppercase">Free Shipping</h2>
                <p>Experience the ease of free shipping on every order. Elevate your shopping without the extra cost—seamless delivery, always on us.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
            <div class="icon mr-4 align-self-start">
                <span class="icon-refresh2"></span>
            </div>
            <div class="text">
                <h2 class="text-uppercase">Free Returns</h2>
                <p>Shop confidently with our hassle-free policy – enjoy free returns on all purchases. We stand behind the quality of our products, and if for any reason you're not completely satisfied, returning your order is on us. </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
            <div class="icon mr-4 align-self-start">
                <span class="icon-help"></span>
            </div>
            <div class="text">
                <h2 class="text-uppercase">Customer Support</h2>
                <p>At Azzstornish, our customer support is ready to assist you. Whether you have questions or need help with your order, we're here for you. Shop with confidence, knowing dedicated support is just a message or call away.</p>
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
    <script></script>
  </body>
</html>