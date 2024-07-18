<!DOCTYPE html>
<html lang="en">  <!-- available for english website -->
<?php 

include "../object/database.php";
include "../object/database2.php";

include "../object/login.php";
include '../phpqrcode/qrlib.php';

session_start();

$Login = new Login("localhost", "user", "password", "finalproject");
$Login2 = new Login2("localhost", "user", "password", "finalproject");


$cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();  // Check if the cart exists in the session.
$cartnumber = 0;  // Initialize a variable to hold the total price.
// Loop through the items in the cart and sum their prices.
foreach ($cartItems as $item) {
    $cartnumber += 1;
}


$pID=empty($_SESSION["pID"])?"":$_SESSION["pID"];
$e=empty($_SESSION["email"])?"":$_SESSION["email"];
$userID=empty($_SESSION["userID"])?"":$_SESSION["userID"];
$pName=empty($_SESSION["pName"])?"":$_SESSION["pName"];
$image=empty($_SESSION["image"])?"":$_SESSION["image"];
$size=empty($_SESSION["size"])?"":$_SESSION["size"];
$price=empty($_SESSION["price"])?"":$_SESSION["price"];
$finalQty=empty($_SESSION["finalQty"])?"":$_SESSION["finalQty"];
$purchaseID=empty($_SESSION['purchaseID'])?"":$_SESSION['purchaseID'];

$receipt=$Login2->showReceipt($purchaseID);
$user=$Login->getUserDetail($userID);
$totalFinalprice=0;
?>
<head>
    <link href='https://fonts.googleapis.com/css?family=Raleway:600,400' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />



    <style>
    body {
      background-image: linear-gradient(to right, rgb(203, 89, 255), rgb(232, 208, 247), rgb(203, 89, 255));
    color: #3a3e59;
    font-family: "Raleway", Arial, sans-serif;
    }
        /* Style for the home button */
        .home-button {
            display: ;
            padding: 10px 20px;
            background-color: #ffffff; /* Button background color */
            color: #582869; /* Button text color */
            text-decoration: none; /* Remove underline from the link */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Add a smooth color transition */
        }

        /* Hover state */
        .home-button:hover {
            background-color: #582869; /* Change the background color on hover */
            color:#ffffff;
        }

        .container{
          height:200px;
          text-align: center;
        }

    p {
    text-align: center;
    opacity: 0.3;
    transition: 0.3s;
    position: absolute;
    bottom: 2vh;
    left: 0;
    right: 0;
    }
    p:hover {
    opacity: 1;
    }

    .receipt {
    max-width: 400px;
    margin: 5vh auto; /* Remove the "0" from the top margin to keep it centered vertically */
    height: auto;
    }

    .receipt_hoverable {
    transition: 0.3s;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    margin: 5vh auto; /* Add the same margin as the .receipt class */
    max-width: 400px; /* Set the maximum width to 200px */
    width: 100%;
}

    .receipt_hoverable:hover {
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .header {
    width: 100%;
    }

    .header__top {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 4px 4px 0 0;
    }

    .header__logo {
    width: 10%;
    padding: 30px;
    }

    .header__meta {
    position: relative;
    width: 90%;
    height: 100%;
    margin-left: 15px;
    line-height: 1.7rem;
   
    }

    .header__serial {
    display: block;
    }

    .header__number {
    position: absolute;
    top: 7.5px;
    right: 0;
    transform: rotate(270deg);

    }

    .header__greeting {
    clear: both;
    }

    .header__greeting {
    position: relative;
    background: white;
    padding: 0 15px;
    padding-left: 30px;
    }

    .header__name {
    display: block;
    font-weight: bold;
    font-size: 1.3rem;
    margin-bottom: 7.5px;
    }

    .header__count {

    font-size: 90%;
    }

    .header__border {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background-color: #429fff;
    }

    .header__spacing {
    display: block;
    background: white;
    height: 22.5px;
    }

    .cart {
    background: white;
    padding: 30px;
    padding-top: 15px;
    border-bottom: 2px dashed #ff84a1;
    border-radius: 0 0 5px 5px;

    }

    .cart__header {
    margin-top: 0;
    text-align: center;
    }

    .cart__hr {
    border: none;
    padding: 0;
    margin: 0;
    margin-bottom: 22.5px;
    border-bottom: 3px solid #fee469;
    }


    .list__item:last-child {
    border-bottom: none;
    }
    .list__item:before {
    margin-right: 15px;
    }

    .list {
    list-style: none;
    padding: 0;
}

.list__item {
    border-bottom: 1px solid #ccc; /* Add a line (border) at the bottom of each row */
    margin-top: 10px; /* Add margin at the top of each row for separation */
    padding: 10px 0;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr; /* Define 3 columns with equal width */
    align-items: center;
}

.list__name {
    font-weight: bold;
}

.list__qty {
    text-align: right;
    font-weight: bold;
}

.list__price {
    text-align: right;
    font-weight: bold;
}




    .cart__total {
    display: flex;
    width: 100%;
    }

    .cart__total-label {
    margin: 0;
    flex: 1;
    text-transform: uppercase;
    }

    .cart__total-price {
    align-self: flex-end;
    font-weight: bold;
    text-align: right;
    }



    .bar-code {
    display: flex;
    background: white;

    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    /* Add any other styles you need for the bar-code container */
}

.bar-code__code {
    /* Add styles for the container if needed */
}

.bar-code__code img {
    max-width: 100%; /* Ensure the image doesn't exceed its container's width */
    max-height: 100%; /* Ensure the image doesn't exceed its container's height */
}

    .button {
    position: fixed;
    bottom: 15px;
    right: 15px;
    background: #ff517a;
    border: none;
    border-radius: 3px;
    color: white;
    padding: 15px;
    transition: 0.3s;
    }
    .button:hover {
    box-shadow: 0 2px 10px #b7002b;
    }

    .link {
    display: block;
    margin: 25px auto 15px auto;
    text-align: center;
    }

    #replayButton {
    display: none;
    }

    </style>

</head>
<body>
    <?php 
    $item="";
    $price="";
    $qty="";
    $totalPrice="";

      $item=explode("\n", $receipt["item"]);
      $price=explode("\n", $receipt["price"]);
      $qty=explode("\n", $receipt["qty"]);
      $totalPrice=explode("\n", $receipt["totalPrice"]);
      $totalFinalprice=0;
      $n=count($item);
      $c=0;
      for($i = 0; $i < $n; $i++)
      {
        $c+=$qty[$i];
      }

      if(count($item)==1)
      {
        ?>
    <div class="receipt">
	
  <header class="header">
      <div class="header__top">
          <div class="header__logo">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.58 30.18"><defs><style>.a{fill:#253b80;}.b{fill:#179bd7;}.c{fill:#222d65;}</style></defs><title>PayPal</title><path class="a" d="M7.27,29.15l0.52-3.32-1.16,0H1.06L4.93,1.29A0.32,0.32,0,0,1,5,1.1,0.32,0.32,0,0,1,5.24,1h9.38C17.73,1,19.88,1.67,21,3a4.39,4.39,0,0,1,1,1.92,6.92,6.92,0,0,1,0,2.64V8.27l0.53,0.3a3.69,3.69,0,0,1,1.07.81,3.78,3.78,0,0,1,.86,1.94,8.2,8.2,0,0,1-.12,2.81,9.9,9.9,0,0,1-1.15,3.18,6.55,6.55,0,0,1-1.83,2,7.4,7.4,0,0,1-2.46,1.11,12.26,12.26,0,0,1-3.07.35H15.12a2.2,2.2,0,0,0-2.17,1.85l-0.06.3L12,28.78l0,0.22a0.18,0.18,0,0,1-.06.13,0.15,0.15,0,0,1-.1,0H7.27Z"/><path class="b" d="M23,7.67h0q0,0.27-.1.55c-1.24,6.35-5.47,8.55-10.87,8.55H9.33A1.34,1.34,0,0,0,8,17.89H8L6.6,26.83,6.2,29.36a0.7,0.7,0,0,0,.7.81h4.88a1.17,1.17,0,0,0,1.16-1l0-.25,0.92-5.83L14,22.79a1.17,1.17,0,0,1,1.16-1h0.73c4.73,0,8.43-1.92,9.51-7.48,0.45-2.32.22-4.26-1-5.62A4.67,4.67,0,0,0,23,7.67Z"/><path class="c" d="M21.75,7.15L21.17,7l-0.62-.12a15.28,15.28,0,0,0-2.43-.18H10.77a1.17,1.17,0,0,0-1.16,1L8,17.6l0,0.29a1.34,1.34,0,0,1,1.32-1.13h2.75c5.4,0,9.64-2.19,10.87-8.55C23,8,23,7.85,23,7.67a6.59,6.59,0,0,0-1-.43Z"/><path class="a" d="M9.61,7.7a1.17,1.17,0,0,1,1.16-1h7.35a15.28,15.28,0,0,1,2.43.18L21.17,7l0.58,0.15L22,7.24a6.69,6.69,0,0,1,1,.43c0.37-2.35,0-3.94-1.27-5.39S17.85,0,14.62,0H5.24A1.34,1.34,0,0,0,3.92,1.13L0,25.9a0.81,0.81,0,0,0,.8.93H6.6L8,17.6Z"/></svg>
          </div>
          <div class="header__meta">
              <span class="header__date"><?php echo $receipt["purchaseTime"]?></span>
              <span class="header__serial">PID: <?php echo $receipt["purchaseID"]?></span>
          </div>
      </div>
      <div class="header__greeting">
          <span class="header__name"><?php echo $user["Name"]?></span>
          <span class="header__count">You've purchased <?php echo $c?> items in our store.</span>
          <span class="header__border"></span>
      </div>
      <div class="header__spacing"></div>
  </header>
  
  <section class="cart">
          <h2 class="cart__header">Cart:</h2>
          <ol class="list">
            <li class="list__item">
                <span class="list__name">Item</span>
                <span class="list__qty">Quantity</span>
                <span class="list__price">Total Price</span>
            </li>
            <?php

                echo '<li class="list__item">';
                echo '<span class="list__name">' . $item[0] . '</span>';
                echo '<span class="list__qty">' . $qty[0] . '</span>';
                echo '<span class="list__price">' . $totalPrice[0] . '</span>';
                echo '</li>';


                $cleanedValue = trim(preg_replace("/[^0-9.]/", "", $totalPrice[0]));
                
                $totalFinalprice = (float) $cleanedValue;
                $finalPriceWithTax = $totalFinalprice * 1.08; 
             
              ?>
        </ol>


          <hr class="cart__hr" />
          <footer class="cart__total">
              <h3 class="cart__total-label">Total</h3>
              <span class="cart__total-price">$<?php echo $totalFinalprice?></span>				
          </footer>
          <footer class="cart__total">
              <h3 class="cart__total-label">Total (Included 8% tax)</h3>
              <span class="cart__total-price">$<?php echo number_format($totalFinalprice * 1.08, 2); ?></span>
          </footer>
  </section>
  
  <footer class="bar-code">
      <div class="bar-code__code">
      <img src="<?php echo $receipt["qr"]?>" alt="Your QR Code Image">
      </div>
  </footer>
</div>

<button id="replayButton" type="button" onclick="restart()">Replay</button>
<div class="container">
 <a class="home-button" href="index.php">Home Page</a>
</div>



<?php
      }
      else
      {
  ?>  
    <div class="receipt">
	
        <header class="header">
            <div class="header__top">
                <div class="header__logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.58 30.18"><defs><style>.a{fill:#253b80;}.b{fill:#179bd7;}.c{fill:#222d65;}</style></defs><title>PayPal</title><path class="a" d="M7.27,29.15l0.52-3.32-1.16,0H1.06L4.93,1.29A0.32,0.32,0,0,1,5,1.1,0.32,0.32,0,0,1,5.24,1h9.38C17.73,1,19.88,1.67,21,3a4.39,4.39,0,0,1,1,1.92,6.92,6.92,0,0,1,0,2.64V8.27l0.53,0.3a3.69,3.69,0,0,1,1.07.81,3.78,3.78,0,0,1,.86,1.94,8.2,8.2,0,0,1-.12,2.81,9.9,9.9,0,0,1-1.15,3.18,6.55,6.55,0,0,1-1.83,2,7.4,7.4,0,0,1-2.46,1.11,12.26,12.26,0,0,1-3.07.35H15.12a2.2,2.2,0,0,0-2.17,1.85l-0.06.3L12,28.78l0,0.22a0.18,0.18,0,0,1-.06.13,0.15,0.15,0,0,1-.1,0H7.27Z"/><path class="b" d="M23,7.67h0q0,0.27-.1.55c-1.24,6.35-5.47,8.55-10.87,8.55H9.33A1.34,1.34,0,0,0,8,17.89H8L6.6,26.83,6.2,29.36a0.7,0.7,0,0,0,.7.81h4.88a1.17,1.17,0,0,0,1.16-1l0-.25,0.92-5.83L14,22.79a1.17,1.17,0,0,1,1.16-1h0.73c4.73,0,8.43-1.92,9.51-7.48,0.45-2.32.22-4.26-1-5.62A4.67,4.67,0,0,0,23,7.67Z"/><path class="c" d="M21.75,7.15L21.17,7l-0.62-.12a15.28,15.28,0,0,0-2.43-.18H10.77a1.17,1.17,0,0,0-1.16,1L8,17.6l0,0.29a1.34,1.34,0,0,1,1.32-1.13h2.75c5.4,0,9.64-2.19,10.87-8.55C23,8,23,7.85,23,7.67a6.59,6.59,0,0,0-1-.43Z"/><path class="a" d="M9.61,7.7a1.17,1.17,0,0,1,1.16-1h7.35a15.28,15.28,0,0,1,2.43.18L21.17,7l0.58,0.15L22,7.24a6.69,6.69,0,0,1,1,.43c0.37-2.35,0-3.94-1.27-5.39S17.85,0,14.62,0H5.24A1.34,1.34,0,0,0,3.92,1.13L0,25.9a0.81,0.81,0,0,0,.8.93H6.6L8,17.6Z"/></svg>
                </div>
                <div class="header__meta">
                    <span class="header__date"><?php echo $receipt["purchaseTime"]?></span>
                    <span class="header__serial">PID: <?php echo $receipt["purchaseID"]?></span>
                </div>
            </div>
            <div class="header__greeting">
                <span class="header__name"><?php echo $user["Name"]?></span>
                <span class="header__count">You've purchased <?php echo $c?> items in our store.</span>
                <span class="header__border"></span>
            </div>
            <div class="header__spacing"></div>
        </header>
        
        <section class="cart">
                <h2 class="cart__header">Cart:</h2>
                <ol class="list">
                  <li class="list__item">
                      <span class="list__name">Item</span>
                      <span class="list__qty">Quantity</span>
                      <span class="list__price">Total Price</span>
                  </li>
                  <?php
                  
                  for ($i = 0; $i < $n; $i++) {
                      echo '<li class="list__item">';
                      echo '<span class="list__name">' . $item[$i] . '</span>';
                      echo '<span class="list__qty">' . $qty[$i] . '</span>';
                      echo '<span class="list__price">' . $totalPrice[$i] . '</span>';
                      echo '</li>';
                      $cleanedValue = trim(preg_replace("/[^0-9.]/", "", $totalPrice[$i]));
                
                      // Convert the cleaned value to a float
                      $totalFinalprice += (float) $cleanedValue;                  
                    }
                  ?>
              </ol>


                <hr class="cart__hr" />
                <footer class="cart__total">
                    <h3 class="cart__total-label">Total</h3>
                    <span class="cart__total-price">$<?php echo $totalFinalprice?></span>				
                </footer>
                <footer class="cart__total">
                    <h3 class="cart__total-label">Total (Included 8% tax)</h3>
                    <span class="cart__total-price">$<?php echo number_format($totalFinalprice * 1.08, 2); ?></span>
                </footer>
        </section>
        
        <footer class="bar-code">
            <div class="bar-code__code">
            <img src="<?php echo $receipt["qr"]?>" alt="Your QR Code Image">
            </div>
        </footer>
    </div>
    
    <button id="replayButton" type="button" onclick="restart()">Replay</button>
    <div class="container">
       <a class="home-button" href="index.php">Home Page</a>
    </div>
 <?php }?>   

</body>
<script>
    // Shorten typing because I'm lazy
function qsa(el) { return document.querySelectorAll(el); }

// Restart animation button
function restart() {
  tl.restart();
  document.getElementById('replayButton').style.display = 'none'; // Hide the button
}

var tl = new TimelineMax({ repeat: 0 });

// Elements to animate
var receipt = qsa('.receipt');
var greetingBorder = qsa('.header__border');
var greetingName = qsa('.header__name');
var greetingCount = qsa('.header__count');
var cart = qsa('.cart');
var barCode = qsa('.bar-code');
var cartHeader = qsa('.cart__header');
var listItems = qsa('.list__item');
var cartBorder = qsa('.cart__hr');
var total = qsa('.cart__total');

// Animation timeline
tl.fromTo(
  receipt,
  0.5,
  {
    alpha: 0,
    transformOrigin: "50% 20%",
  },
  {
    alpha: 1,
    ease: Power2.easeOut, // Apply easing
  }
)
.from(
  greetingBorder,
  0.5,
  {
    x: 15,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  }
)
.from(
  greetingName,
  0.5,
  {
    y: 15,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  },
  '-=0.5'
)
.from(
  greetingCount,
  0.3,
  {
    y: 15,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  },
  '-=0.2'
)
.addLabel('header')
.fromTo(
  cart,
  0.3,
  {
    rotationX: "-90deg",
    transformPerspective: 500,
    force3D: true,
    transformOrigin: "top center",
    transformStyle: "preserve-3d",
  },
  {
    transformPerspective: 500,
    rotationX: '0deg',
    ease: Power2.easeOut, // Apply easing
  }
)
.fromTo(
  barCode,
  0.3,
  {
    rotationX: "-90deg",
    transformPerspective: 500,
    force3D: true,
    transformOrigin: "top center",
    transformStyle: "preserve-3d",
  },
  {
    transformPerspective: 500,
    rotationX: '0deg',
    ease: Power2.easeOut, // Apply easing
  }
)
.to(
  receipt,
  0.5,
  {
    css: {
      className: '+=receipt_hoverable',
    },
    ease: Power2.easeOut, // Apply easing
  }
)
.from(
  cartHeader,
  0.5,
  {
    y: 10,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  },
  '-=0.4'
)
.staggerFrom(
  listItems,
  0.5,
  {
    x: -10,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  },
  0.3
)
.from(
  cartBorder,
  0.5,
  {
    y: 25,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  },
  '-=0.3'
)
.from(
  total,
  0.5,
  {
    y: 50,
    autoAlpha: 0,
    ease: Power2.easeOut, // Apply easing
  },
  '-=.4'
);
</script>
</html>