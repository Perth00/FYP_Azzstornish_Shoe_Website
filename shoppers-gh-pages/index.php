<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />

<?php
include "../object/database.php";
include "../object/login.php";
session_start();
$e=empty($_SESSION["email"])?"":$_SESSION["email"];
$image=empty($_SESSION["image"])?"":$_SESSION["image"];
$userID=empty($_SESSION["userID"])?"":$_SESSION["userID"];
$Login = new Login("localhost", "user", "password", "finalproject");
$register = new register("localhost", "user", "password", "finalproject");


$TimeOfLogin=!isset($_SESSION["TimeOfLogin"])?0:$_SESSION["TimeOfLogin"];
$currentDate = date("Y-m-d");

// Calculate the expiration date one month later
$expirationDate = date("Y-m-d", strtotime("+1 month", strtotime($currentDate)));


$cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();  // Check if the cart exists in the session.
$cartnumber = 0;  // Initialize a variable to hold the total price.
// Loop through the items in the cart and sum their prices.
foreach ($cartItems as $item) {
    $cartnumber += 1;
}


$category = [];
$category = $Login->showCategory();
$product = [];
$product = $Login->showTopProduct();
if (isset($_POST["submit2"])) {

    $email = !empty($_POST["email"]) ? $_POST["email"] : "";
    $password = !empty($_POST["password"]) ? $_POST["password"] : "";
    $register->login($email, $password);

}


$isUserRegistered = false;
if(empty($userID))
{
    if (!$isUserRegistered) {
        echo '<div id="lucky-draw-message">';
        echo '<p><strong><a href="../Registration/register.php">Register now</a> and get a chance to win in our lucky draw! New users are eligible for the lucky draw. You can register an account to play our game and get a discount voucher if you play over 500 pieces. Don\'t miss out!</strong></p>';
        echo '<span id="close-btn" onclick="closeMessage()">X</span>';
        echo '</div>';
        
    }
}

?>
<script>
    function closeMessage() {
        var message = document.getElementById('lucky-draw-message');
        message.style.display = 'none';
    }
</script>


<style>

#lucky-draw-message {
    background-color: black;
    color: white;
    padding: 15px;
    text-align: center;
    border-radius: 10px;
    margin-bottom: 20px;
    position: relative;
}

#lucky-draw-message a {
    text-decoration: none;
    color: #7971ea;
    transition: color 0.3s ease; /* Adding a smooth transition effect */
}

#lucky-draw-message a:hover {
    color: white; /* Change the color on hover */
}

#close-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    color: white;
    cursor: pointer;
    font-size: 18px;
}

#close-btn:hover {
    color: #bd2130;
}

        /* Styles for the overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        #popupOverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Adjust the opacity as needed */
      justify-content: center;
      align-items: center;
    }

    .popup-container {
            background: black;
            padding: 20px;
            }

        #spin-container {
        max-width: 600px;
        margin: 0 auto;
        }
        .spin-to-win {
        max-width: 600px;
        }
        .spin-to-win img {
        width: 100%;
        height: auto;
        }

        #spinner {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        }

        #spin-btn {
        cursor: pointer;
        background: white;
        /*   background-image:url('https://contentservice.mc.reyrey.net/image_v1.0.0/?id=d08f9524-26eb-53be-a6a1-bc8d8e19cc20&637070095483683129'); */
        background-size: 100% 100%;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
        animation: spinBtn 2s linear infinite;
        border: 5px solid transparent;
        text-align: center;
        }
        #spin-btn p {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        font-family: "Montserrat", sans-serif;
        }

        @keyframes spinBtn {
        0% {
            border: 5px solid black;
        }
        50% {
            border: 5px solid red;
        }
        100% {
            border: 5px solid black;
        }
        }

        #spin-btn,
        #spin-arrow {
        max-width: 180px;
        width: calc(100vw * 0.3);
        max-height: 180px;
        height: calc(100vw * 0.3);
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        }

        #spin-arrow {
        transition-timing-function: ease-in-out;
        transition: 3s;
        }
        #spin-arrow:after {
        content: "";
        position: absolute;
        left: 2px;
        top: 2px;
        width: calc(100vw * 0.14167);
        max-width: 85px;
        height: calc(100vw * 0.14167);
        max-height: 85px;
        background-color: white;
        box-shadow: -2px -2px 10px rgba(0, 0, 0, 0.25);
        }

        /* btn styles */
        #si-btn {
        max-width: 320px;
        background: white;
        color: black;
        text-align: center;
        font-family: sans-serif;
        border-radius: 15px;
        margin: 0 auto 25px auto;
        padding: 0px;
        /*   transition:2s; */
        filter: invert(1);
        opacity: 0;
        }
        #si-btn:hover {
        background:#e81238;
        } 
        #si-btn a {
        color: inherit;
        text-decoration: none;
        display: inline-block;
        padding: 20px 35px;
        }
        /* btn styles */

        /* OFFER STYLES */
        .spin-offer {
        max-width: 600px;
        padding: 20px;
        /*   border:10px solid lightgray; */
        border-radius: 15px;
        text-align: center;
        font-size: 24px;
        font-family: sans-serif;
        position: relative;
        display: none;
        vertical-align: middle;
        animation: spin 2s linear forwards;
        color: white;
        box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.25);
        margin-bottom: 30px;
        }
        @keyframes spin {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
        }

        .spin-offer .item {
        padding: 10px;
        }

        .spin-title {
        }
        .spin-price {
        font-size: 60px;
        line-height: 60px;
        padding-bottom: 0px !important;
        }
        .spin-info {
        padding-top: 0px !important;
        }
        .spin-disc {
        font-size: 12px;
        }

    </style>
    <link href="https://fonts.googleapis.com/css?family=Raleway:800" rel="stylesheet">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <div class="site-blocks-cover"
         style="background-image: url(images/Product/banner_aj5_1200x.jpg);" data-aos="fade">
        <div class="container">
            <div class="row align-items-start align-items-md-center justify-content-end">
                <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                    <h1 class="mb-2">Welcome to Azzstornish!</h1>
                    <div class="intro-text text-center text-md-left">
                        <p class="mb-4">Discover the perfect pair that complements your style – step into comfort and fashion with our exclusive shoe collection!</p>
                        <p>
                            <a href="shop.php" class="btn btn-sm btn-primary">Shop Now</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section site-section-sm site-blocks-1">
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

    <div class="site-section site-blocks-2">
        <div class="container">
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

    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Top Products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                    <?php
                foreach ($product as $product) {
                    ?>
                        <!--Show the product-->
                        <div class="item">
                            <div class="block-4 text-center">
                                <figure class="block-4-image">
                                    <img src="../Admin/image/<?php echo $product["image"]?>" alt="Image placeholder" class="img-fluid" style="width: 500px; height: 300px;" >
                                </figure>
                                <div class="block-4-text p-4">
                                    <h3><a href="#"><?php echo $product["pName"]?></a></h3>
                                    <p class="mb-0"><?php echo $product["series"]?></p>
                                    <p class="text-primary font-weight-bold"><?php echo $product["price"]?></p>
                                </div>
                            </div>
                        </div>
                  <?php }?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="overlay" id="popupOverlay">
    <div class="popup-container">
      <!-- Add your existing popup content here -->
      <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

      <div id="spin-container">
        <div id="spinner" class="spin-to-win">
          <img src="images/WheelofFortune.jpeg" />
          <div id="spin-arrow"></div>
          <div id="spin-btn" onclick="unsetSessionTime()"><p>TRY YOUR<br><span style="font-size:36px;font-weight:900">LUCK</span><p></div>
        </div>


        <!-- OFFERS  -->
        <div id="lightestBlue" class="spin-offer">
          <div class="spin-price item">10% OFF</div>
          <div class="spin-info item">For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="green" class="spin-offer">
          <div class="spin-price item">25% OFF</div>
          <div class="spin-info item">For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="gold" class="spin-offer">
          <div class="spin-price item">20% OFF</div>
          <div class="spin-info item">For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="orange" class="spin-offer">
          <div class="spin-price item">15% OFF</div>
          <div class="spin-info item"> For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="red" class="spin-offer">
          <div class="spin-price item">40% OFF</div>
          <div class="spin-info item"> For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="maroon" class="spin-offer">
          <div class="spin-price item">30% OFF</div>
          <div class="spin-info item">For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="darkblue" class="spin-offer">
          <div class="spin-price item">10% OFF</div>
          <div class="spin-info item">For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
                    <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
        </div>

        <div id="blue" class="spin-offer">
          <div class="spin-price item">50% OFF</div>
          <div class="spin-info item">For Any Shoes</div>
          <div class="spin-disc item">
                Online store exclusive. One per customer. No cash value.
                No further discounts apply. Expires <?php echo $expirationDate; ?>.
        </div>
          <button class="btn btn-primary" onclick="goToHomePage()">Go Back to Home</button>
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

<script src="js/main.js"></script>
<script src="js/add.js"></script>
<script>
    // Check if $TimeOfLogin is equal to 1
    var timeOfLogin = <?php echo $TimeOfLogin; ?>;
    if (timeOfLogin === 1) {
      // If true, show the overlay and popup
      document.getElementById('popupOverlay').style.display = 'flex';
    }
</script>

<script>
    // Your existing spinToWin script...
    var angles = [22.5, 67.5, 112.5, 157.5, 202.5, 247.5, 292.5, 337.5];
    var colors = [
      "#2cc5d2",
      "#38c88e",
      "#fab320",
      "#f97903",
      "#ca2231",
      "#79022c",
      "#0a4366",
      "#0a97d0"
    ];
    var spinBtn = document.querySelector("#spin-btn");
    var spinArrow = document.querySelector("#spin-arrow");
    var offerBtn = document.querySelector("#si-btn");
    var spinOffer = document.querySelectorAll(".spin-offer");
    var selectedPercentage = 0;

    var urlSpin = new URL(document.location).searchParams;
    var spinname = urlSpin.get("nlmlp");
    if (spinname == null || spinname == "") {
      spinname = "z";
    }
    var num = spinname.length > 7 ? Math.floor(spinname.length / 8) - 1 : spinname.length;

    function spinToWin() {
      var randomIndex = Math.floor(Math.random() * spinOffer.length);

      spinOffer.forEach(function (offer) {
        offer.style.background = "transparent";
        offer.style.display = "none";
      });

      num = randomIndex;

      spinBtn.style.pointerEvents = "none";
      spinBtn.style.animation = "none";

      spinArrow.style.transform = "rotate(" + (360 * 5 + angles[num]) + "deg)";

      spinOffer[num].style.background = colors[num];

      selectedPercentage = parseInt(spinOffer[num].querySelector('.spin-price').innerText);



      setTimeout(function () {
        spinOffer[num].style.display = "inline-block";
        offerBtn.style.opacity = "1";
        offerBtn.style.transition = "1.5s";
      }, 3000);
    }

    spinBtn.addEventListener("click", function () {
    spinToWin();

    // Create an AJAX request to set the session variable and update the database
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "test.php?percentage=" + selectedPercentage, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText;

            if (response === "Success") {
            } else {
                alert("Error: " + response);
            }
        } else {
            alert("Error setting session variable");
        }
    };

    xhr.send();
});

</script>

<script>
  // Function to go back to the home page, clear session, and close the popup
  function goToHomePage() {
    var xhr = new XMLHttpRequest();

    var homepageUrl = 'index.php';

    document.getElementById('popupOverlay').style.display = 'none';

    window.location.href = homepageUrl;
  }
</script>

<script>
  function unsetSessionTime() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "clear_session.php", true);
    xhr.send();
  }
</script>
<script>
if(document.getElementById('popupOverlay').style.display =='flex') {
    window.addEventListener('beforeunload', function (e) {
      var confirmationMessage = 'If you reload the page, your lucky draw chance will be gone. Are you sure you want to leave?';
      e.returnValue = confirmationMessage; // Standard for most browsers
      return confirmationMessage; // For some older browsers
    });
}
</script>

</body>

</html>
