<!DOCTYPE html>
<html lang="en">
<?php 
  include "../object/database.php";
  include "../object/database2.php";

  include "../object/login.php";
  include '../phpqrcode/qrlib.php';

  session_start();
  $pID=empty($_SESSION["pID"])?"":$_SESSION["pID"];
  $e=empty($_SESSION["email"])?"":$_SESSION["email"];
  $userID=empty($_SESSION["userID"])?"":$_SESSION["userID"];
  
  

  $cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();  // Check if the cart exists in the session.
  $cartnumber = 0;  // Initialize a variable to hold the total price.
  // Loop through the items in the cart and sum their prices.
  foreach ($cartItems as $item) {
      $cartnumber += 1;
  }

  $pName=empty($_SESSION["pName"])?"":$_SESSION["pName"];
  $image=empty($_SESSION["image"])?"":$_SESSION["image"];
  $size=empty($_SESSION["size"])?"":$_SESSION["size"];
  $price=empty($_SESSION["price"])?"":$_SESSION["price"];
  $finalQty=empty($_SESSION["finalQty"])?"":$_SESSION["finalQty"];
  $Login = new Login("localhost", "user", "password", "finalproject");
  $Login2 = new Login2("localhost", "user", "password", "finalproject");

  $email2 = new email2();
  $cartItems=empty($_SESSION["cart"])?"":$_SESSION["cart"];
  $totalPriceForQr = 0; // Initialize $totalPriceForQr
  $totalTaxPriceForQr = 0; // Initialize $totalTaxPriceForQr
  $c=$Login->showvoucher($userID);
  
  $subPrice=0;
  // Get the current date and time
  $currentDateTime = date("H:i:sY-m-d"); // Adjust the format to your preference
  $currentDateTimeFile = str_replace(":", "_", $currentDateTime); // Replace hyphens with underscores
  $currentDateTimeRec = date("H:i:s Y-m-d"); // Adjust the format to your preference

  $category = [];
  $category = $Login->showCategory();


  if(isset($_POST["submit"]))
{
        $index = $_POST["index"];
        unset($_SESSION["cart"][$index]);
        $_SESSION["cart"] = array_values($_SESSION["cart"]); // Re-index the array
        header("Location: cart.php");

      
}

if(isset($_POST["update"]))
{
  echo "<script>
  alert('The cart is successfully updated!!!');
  window.location.href = 'cart.php';
  </script>";
}

if(isset($_POST["shopping"]))
{
  header("Location: shop.php");

}

$n = false;

$discount = "";
$code = !empty($_POST["code1"]) ? $_POST["code1"] : "";




$ReceiptOffer=empty($_SESSION["ReceiptOffer"])?0:$_SESSION["ReceiptOffer"];

if (isset($_POST["discount"])) {
    if ($code != "") {

        if($discount = $Login->showDiscount($code))
        {
                if (is_array($discount) && isset($discount["percentage"])) {
                    $coupon = $discount["percentage"];
                    $discount = floatval($coupon); // Convert the string to a float
                    $_SESSION["ReceiptOffer"]=$code;
                    $n=true;

              }
              else
              {

              }
      }else
      {
        $n=false;
        $_SESSION["ReceiptOffer"]=0;

      }
    }else
    {
      $n=false;
      $_SESSION["ReceiptOffer"]=0;
    }
}



//cash on delivery method
if (isset($_POST["pay"])) 
{
  $qtyChecking=false;
  $_SESSION["payment_time"] = $currentDateTime;

  $pNames = array_column($cartItems, "pName");
  $itemArray = implode("_", $pNames);


  $price = array_column($cartItems, "price");
  $priceArray = implode("_", $price);

  $finalQty = array_column($cartItems, "finalQty");
  $finalQtyArray = implode("_", $finalQty);


  $totalPriceStrings = array(); // Initialize an array to store the total price strings
  foreach ($cartItems as $cartItem) {
      $totalPrice = $cartItem["price"] * $cartItem["finalQty"];
      $formattedPrice = "" . number_format($totalPrice, 2); // Format price as a currency with two decimal places
      $totalPriceStrings[] = $formattedPrice; // Add the formatted price to the array
  }
  $itemsTotalPriceString = implode("_", $totalPriceStrings);

  $filepath = "qrcodes/".$currentDateTimeFile.$itemArray.$priceArray.$itemsTotalPriceString.$finalQtyArray.".png";

  // $text variable has data for QR
  // Initialize the $text variable with purchase time
  $text = "Purchase Time is: $currentDateTimeRec";

  $pNames = array_column($cartItems, "pName");
  $price = array_column($cartItems, "price");
  $finalQty = array_column($cartItems, "finalQty");
  $color = array_column($cartItems, "color");
  $pID = array_column($cartItems, "pID");
  $totalPriceStrings = array(); // Initialize an array to store the total price strings

  $qtyCheckingForOverPurchase=0;
  $CurrentqtyCheckingForOverPurchase = $Login2->getProductQty2($pID[0]);
  for ($i = 0; $i < count($finalQty); $i++) 
  {
    $qtyCheckingForOverPurchase+=$finalQty[$i];
  }
  if($CurrentqtyCheckingForOverPurchase>=$qtyCheckingForOverPurchase)
  {
    if($ReceiptOffer==0)
    {
        for ($i = 0; $i < count($pNames); $i++) {
          // Add item name, price, quantity, and total price for each item
          $text .= "\nItem is: {$pNames[$i]} ({$color[$i]})";
          $text .= "\nPrice: {$price[$i]}";
          $text .= "\nTotal Price: " . number_format($price[$i] * $finalQty[$i], 2);
          $text .= "\nQty is: {$finalQty[$i]}\n";
          $qtyChecking=$Login2->deleteProductQty($pID[$i],$finalQty[$i]);
          $totalPriceStrings[] = number_format($price[$i] * $finalQty[$i], 2); // For displaying purposes
          $totalPriceForQr += $price[$i] * $finalQty[$i]; // Accumulate numeric value
          $totalTaxPriceForQr += $price[$i] * $finalQty[$i] * 1.08; // Accumulate numeric value
      }

      $priceArray = implode("\n", $price);
      $itemsTotalPriceString = implode("\n", $totalPriceStrings);
    }else
    {
      $discount = $Login->showDiscount($ReceiptOffer);
      $coupon = $discount["percentage"];

        for ($i = 0; $i < count($pNames); $i++) {
          // Add item name, price, quantity, and total price for each item
          $text .= "\nItem is: {$pNames[$i]} ({$color[$i]})";
          
          $text .= "\nPrice: " . number_format($price[$i] * (1 - $coupon), 2);
          $text .= "\nTotal Price: " . number_format($price[$i] * $finalQty[$i] * (1 - $coupon), 2);
          $text .= "\nQty is: {$finalQty[$i]}\n";
          

          $itemTotalPrice = $price[$i] * $finalQty[$i] * (1 - $coupon);

          // Calculate and add the total price string for this item
          $totalPriceStrings[] =number_format($itemTotalPrice, 2);
          $totalPriceForQr += $itemTotalPrice;
          $totalTaxPriceForQr += $itemTotalPrice * 1.08;

          
          $qtyChecking=$Login2->deleteProductQty($pID[$i],$finalQty[$i]);
          if($qtyChecking==false) // if the product is empty now
          {
            unset($myArray[$i]);
            break;
          }

      }

      $discountedPrices = [];
      foreach ($price as $itemPrice) {
          $discountedPrices[] = $itemPrice;
      }
      $priceArray = implode("\n", $discountedPrices);
      
      $discountedTotalPrices = [];
      foreach ($totalPriceStrings as $totalPrice) {
          $discountedTotalPrices[] = $totalPrice;
      }
      $itemsTotalPriceString = implode("\n", $discountedTotalPrices);
    }

          $text .= "\nTotal Sub Price: $" . number_format($totalPriceForQr, 2);
          $text .= "\nTotal Price (Included 8% Tax): $" . number_format($totalTaxPriceForQr, 2);


          $itemArray = implode("\n", $pNames);
          $finalQtyArray = implode("\n", $finalQty);

          if($qtyChecking==true)
          {
            if(!empty($ReceiptOffer))
            {
              $Login->UploadStatusAvailable($ReceiptOffer);
            }



            QRcode::png($text, $filepath);
            $receipt=$Login->UploadPurchase($currentDateTimeRec,$itemArray,$priceArray,$itemsTotalPriceString,$finalQtyArray,$filepath,"Online",$userID);
            $_SESSION["ReceiptOffer"]=0;
            $_SESSION["purchaseID"]=$receipt["purchaseID"];
            $n=false;
            $email2->sendPurchaseConfirmationEmail($e);
            unset($_SESSION["cart"]);

            if ($totalPriceForQr >= 500) {
              $percentage=15;
              $percentage=$percentage/100;
              $available="available";
              $currentDate = date("Y-m-d"); // Current date in the format YYYY-MM-DD
          
              // Add one month to the current date
              $oneMonthLater = date("Y-m-d", strtotime("+1 month", strtotime($currentDate)));
              $offer = $Login->generateRandomString(6);
              $result = $Login->setVoucher($offer, $percentage, $userID, $available, $oneMonthLater);

              echo "<script>
              alert('Your amount is more than 500, so you obtain a chance to scratch off the discount coupon');
                  window.location.href = 'prize.php';
              </script>";
          }

            echo "<script>
            alert('Payment successful!!!');
            window.location.href = 'receipt.php';
            </script>"; //header to the navigation page with the reminder
          }
          else
          {
            
          }
  }else
  {
    echo "<script>
    alert('We are so sorry the product has been sold off, please choose another product.');
    window.location.href = 'index.php';
    </script>";
  }
  



  }

//cash on delivery method
if (isset($_POST["cashPay"])) 
{
  $qtyChecking=false;
  $_SESSION["payment_time"] = $currentDateTime;

  $pNames = array_column($cartItems, "pName");
  $itemArray = implode("_", $pNames);


  $price = array_column($cartItems, "price");
  $priceArray = implode("_", $price);

  $finalQty = array_column($cartItems, "finalQty");
  $finalQtyArray = implode("_", $finalQty);


  $totalPriceStrings = array(); // Initialize an array to store the total price strings
  foreach ($cartItems as $cartItem) {
      $totalPrice = $cartItem["price"] * $cartItem["finalQty"];
      $formattedPrice = "" . number_format($totalPrice, 2); // Format price as a currency with two decimal places
      $totalPriceStrings[] = $formattedPrice; // Add the formatted price to the array
  }
  $itemsTotalPriceString = implode("_", $totalPriceStrings);

  $filepath = "qrcodes/".$currentDateTimeFile.$itemArray.$priceArray.$itemsTotalPriceString.$finalQtyArray.".png";

  // $text variable has data for QR
  // Initialize the $text variable with purchase time
  $text = "Purchase Time is: $currentDateTimeRec";

  $pNames = array_column($cartItems, "pName");
  $price = array_column($cartItems, "price");
  $finalQty = array_column($cartItems, "finalQty");
  $color = array_column($cartItems, "color");
  $pID = array_column($cartItems, "pID");
  $totalPriceStrings = array(); // Initialize an array to store the total price strings

  $qtyCheckingForOverPurchase=0;
  $CurrentqtyCheckingForOverPurchase = $Login2->getProductQty2($pID[0]);
  for ($i = 0; $i < count($finalQty); $i++) 
  {
    $qtyCheckingForOverPurchase+=$finalQty[$i];
  }
  if($CurrentqtyCheckingForOverPurchase>=$qtyCheckingForOverPurchase)
  {
    if($ReceiptOffer==0)
    {
        for ($i = 0; $i < count($pNames); $i++) {
          // Add item name, price, quantity, and total price for each item
          $text .= "\nItem is: {$pNames[$i]} ({$color[$i]})";
          $text .= "\nPrice: {$price[$i]}";
          $text .= "\nTotal Price: " . number_format($price[$i] * $finalQty[$i], 2);
          $text .= "\nQty is: {$finalQty[$i]}\n";
          $qtyChecking=$Login2->deleteProductQty($pID[$i],$finalQty[$i]);
          $totalPriceStrings[] = number_format($price[$i] * $finalQty[$i], 2); // For displaying purposes
          $totalPriceForQr += $price[$i] * $finalQty[$i]; // Accumulate numeric value
          $totalTaxPriceForQr += $price[$i] * $finalQty[$i] * 1.08; // Accumulate numeric value
      }

      $priceArray = implode("\n", $price);
      $itemsTotalPriceString = implode("\n", $totalPriceStrings);
    }else
    {
      $discount = $Login->showDiscount($ReceiptOffer);
      $coupon = $discount["percentage"];

        for ($i = 0; $i < count($pNames); $i++) {
          // Add item name, price, quantity, and total price for each item
          $text .= "\nItem is: {$pNames[$i]} ({$color[$i]})";
          
          $text .= "\nPrice: " . number_format($price[$i] * (1 - $coupon), 2);
          $text .= "\nTotal Price: " . number_format($price[$i] * $finalQty[$i] * (1 - $coupon), 2);
          $text .= "\nQty is: {$finalQty[$i]}\n";
          

          $itemTotalPrice = $price[$i] * $finalQty[$i] * (1 - $coupon);

          // Calculate and add the total price string for this item
          $totalPriceStrings[] =number_format($itemTotalPrice, 2);
          $totalPriceForQr += $itemTotalPrice;
          $totalTaxPriceForQr += $itemTotalPrice * 1.08;

          
          $qtyChecking=$Login2->deleteProductQty($pID[$i],$finalQty[$i]);
          if($qtyChecking==false) // if the product is empty now
          {
            unset($myArray[$i]);
            break;
          }

      }

      $discountedPrices = [];
      foreach ($price as $itemPrice) {
          $discountedPrices[] = $itemPrice;
      }
      $priceArray = implode("\n", $discountedPrices);
      
      $discountedTotalPrices = [];
      foreach ($totalPriceStrings as $totalPrice) {
          $discountedTotalPrices[] = $totalPrice;
      }
      $itemsTotalPriceString = implode("\n", $discountedTotalPrices);
    }

          $text .= "\nTotal Sub Price: $" . number_format($totalPriceForQr, 2);
          $text .= "\nTotal Price (Included 8% Tax): $" . number_format($totalTaxPriceForQr, 2);


          $itemArray = implode("\n", $pNames);
          $finalQtyArray = implode("\n", $finalQty);

          if($qtyChecking==true)
          {
            if(!empty($ReceiptOffer))
            {
              $Login->UploadStatusAvailable($ReceiptOffer);
            }



            QRcode::png($text, $filepath);
            $receipt=$Login->UploadPurchase($currentDateTimeRec,$itemArray,$priceArray,$itemsTotalPriceString,$finalQtyArray,$filepath,"Cash",$userID);
            $_SESSION["ReceiptOffer"]=0;
            $_SESSION["purchaseID"]=$receipt["purchaseID"];
            $n=false;
            $email2->sendPurchaseConfirmationEmail($e);
            unset($_SESSION["cart"]);

            if ($totalPriceForQr >= 500) {
              $percentage=15;
              $percentage=$percentage/100;
              $available="available";
              $currentDate = date("Y-m-d"); // Current date in the format YYYY-MM-DD
          
              // Add one month to the current date
              $oneMonthLater = date("Y-m-d", strtotime("+1 month", strtotime($currentDate)));
              $offer = $Login->generateRandomString(6);
              $result = $Login->setVoucher($offer, $percentage, $userID, $available, $oneMonthLater);

              echo "<script>
              alert('Your amount is more than 500, so you obtain a chance to scratch off the discount coupon');
                  window.location.href = 'prize.php';
              </script>";
          }

            echo "<script>
            alert('Payment successful!!!');
            window.location.href = 'receipt.php';
            </script>"; //header to the navigation page with the reminder
          }
          else
          {
            
          }
  }else
  {
    echo "<script>
    alert('We are so sorry the product has been sold off, please choose another product.');
    window.location.href = 'index.php';
    </script>";
  }
  



  }

  ?>

  <head>
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

    <script>
      function hidePaymentFields() {
          // Hide the online payment fields when the cash on delivery radio button is selected
          document.getElementById('payment-fields').style.display = 'none';
          // Show the card on delivery fields
          document.getElementById('card-fields').style.display = 'block';
      }
      function showCardFields() {
          // Show the card on delivery fields when the corresponding radio button is selected
          document.getElementById('card-fields').style.display = 'block';
          // Hide the online payment fields
          document.getElementById('payment-fields').style.display = 'none';
      }

      function showPaymentFields() {
          // Show the online payment fields when the corresponding radio button is selected
          document.getElementById('payment-fields').style.display = 'block';
          // Hide the card on delivery fields
          document.getElementById('card-fields').style.display = 'none';
      }
    </script>


    <style>
        /* Styles for hiding the payment fields initially */
        .payment-fields {
            display: none;
        }

        /* Style for radio button container */
        .radio-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        /* Style for radio button label */
        .radio-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-right: 15px;
        }

        /* Style for custom radio button */
        .custom-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #7971ea;
            border-radius: 50%;
            margin-right: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s; /* Add transition for hover effect */
        }

        /* Style for custom radio button when selected */
        .custom-radio.selected {
            background-color: #007BFF;
        }

        /* Hover effect for radio label when the associated radio button is selected */
        .radio-label:hover .custom-radio {
            background-color: #7971ea; /* Change the background color on hover */
        }

        /* Style for selected radio label */
        .radio-label.selected {
            font-weight: bold; /* Make the text bold for the selected radio label */
            color: #007BFF; /* Change the text color for the selected radio label */
        }

        /* Style for selected custom radio button */
        .custom-radio.selected {
            background-color: #007BFF; /* Change the background color for the selected custom radio button */
            border: 2px solid #007BFF; /* Change the border color for the selected custom radio button */
        }

        /* Hide default radio button */
        input[type="radio"] {
            display: none;
        }


.style-2 del {
  color: rgba(128, 128, 128, 0.5);
  text-decoration: none;
  position: relative;
  font-size: 30px;
  font-weight: 100;
}
.style-2 del:before {
  content: " ";
  display: block;
  width: 100%;
  border-top: 2px solid rgba(128, 128, 128, 0.8);
  border-bottom: 2px solid rgba(128, 128, 128, 0.8);
  height: 4px;
  position: absolute;
  bottom: 22px;
  left: 0;
  transform: rotate(-11deg);
}
.style-2 ins {
  color:red;

  font-size: 80px;
  font-weight: 100;
  text-decoration: none;
  padding: 1em 1em 1em 0.5em;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
    max-width: 400px;
    position: relative;
}

.close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 10px;
    cursor: pointer;
}

/* Styles for the payment form */
.payment-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    background: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 10px;
}

label {
    display: block;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submit-button {
    background-color: #7971ea;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px;
    width: 100%;
    cursor: pointer;
}

.coupon-dropdown {
        width: 300px; /* Adjust the width as needed */
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        color: #333;
    }

    /* Style for the options in the coupon dropdown */
    .coupon-dropdown option {
        font-weight: bold;
        color: #0066cc;
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
                    <li >
                        <a href="about.php">About</a>
                    </li>
                    <li><a href="shop.php">Shop</a></li>
                    <li class="active"><a href="cart.php">cart</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!--End navigation-->

    <div class="overlay" id="login-overlay">
        <div class="login-container">
            <!-- Add the close button (X) here -->
            <span class="close-button" id="close-login" onclick="closeLogin()"
                  style="font-size: 50px;">&times;</span>
            <h2 class="login-title">Login</h2>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit2">Login</button>
                </div>
            </form>
            <!-- Add buttons container with Flexbox -->
            <div class="buttons-container">
                <!-- Container for the top row of links -->
                <div class="top-row-links">
                    <!-- Forgot Password button (left) -->
                    <p class="forgot-password"><a href="#">Forgot Password?</a></p>
                    <!-- Admin Login button (right) -->
                    <p class="admin-login"><a href="#">Admin Login</a></p>
                </div>
                <p class="register-account">Don't have an account<a href="../Registration/register.php">Register
                        Account</a></p>
            </div>
        </div>
    </div>
    <!--End navigation-->

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <form class="col-md-12" method="post">
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>  

              <?php   
                  if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
                    $totalItems = count($cartItems);

                    for ($index = 0; $index < $totalItems; $index++) {
                        $cartItem = $cartItems[$index];
                        $subPrice+=$cartItem["price"]*$cartItem["finalQty"];
                        echo '<tbody>
                                <tr>
                                    <td class="product-thumbnail">
                                        <img src="../Admin/image/' . $cartItem["image"] . '" alt="Image" class="img-fluid">
                                    </td>
                                    <td class="product-name">
                                    <h2 class="h5 text-black">' . $cartItem["pName"] . ' (' . $cartItem["color"] . ') (' . $cartItem["size"] . ')</h2>
                                    </td>
                                    <td>$' . $cartItem["price"] . '</td>
                                    <td>
                                        ' . $cartItem["finalQty"] . '
                                    </td>                                            
                                    <td>' . $cartItem["price"]*$cartItem["finalQty"] . '</td>
                                    <td>
                                      <form action="cart.php" method="POST">
                                            <input type="hidden" name="index" value="' . $index . '">
                                            <button type="submit" name="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to remove this item from your cart?\')">Remove</button>
                                      </form>
                                    </td>
                                </tr>
                            </tbody>';
                    }
                  } else {
                    // Handle the case where the cart is empty
                    echo '<p>Your cart is empty.</p>';
                  }
                    ?>


              </table>
            </div>
          </form>
        </div>

        <form action="cart.php" method="POST">
        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <button name="update" class="btn btn-primary btn-sm btn-block">Update Cart</button>
              </div>
              <div class="col-md-6">
                <button name="shopping" class="btn btn-outline-primary btn-sm btn-block" onclick="return confirm('Do you want to continue to shopping??')">Continue Shopping</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="text-black h4" for="coupon">Coupon</label>
                <p>Enter your coupon code if you have one.</p>
              </div>
              <div class="col-md-8 mb-3 mb-md-0">
              <select name="code1" class="coupon-dropdown">
                <?php foreach ($c as $couponItem) { ?>
                    <option value="<?php echo $couponItem["offer"] ?>" <?php echo ($couponItem["offer"] == "SpecialOffer123") ? 'selected' : ''; ?>>
                        <?php echo $couponItem["offer"] ?> - <?php echo $couponItem["percentage"] * 100 ?>% Off, Due Date: <?php echo $couponItem["date"] ?>
                    </option>

                <?php } ?>
            </select>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary btn-sm" name="discount" >Apply Coupon</button>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">


                  <?php 
                  if($n==true)
                  {
                    $s = $subPrice * (1 - $coupon);
                    $p = number_format($s, 2, '.', '');
                    $sub = number_format($subPrice, 2, '.', '');

                    ?>
                    <div class="style-2">
                      <del>
                        <span class="amount">$<?php echo $sub?></span>
                      </del>
                      <ins>
                        <span class="amount">$<?php echo $p;?></span>
                      </ins>
                    </div>

                  <?php 
                  }else{
                    $sub = number_format($subPrice, 2, '.', '');
                    ?>
                  
                    <strong class="text-black">$<?php echo $sub?></strong>
                  <?php }?>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total<br> (included 8% tax)</span>
                  </div>
                  <div class="col-md-6 text-right">
                  <?php 

                  if($n==true)
                  {
                    $s = $subPrice * (1 - $coupon);
                    $s1=$s*1.08;
                    $subPrice1=$subPrice*1.08;
                    $p1 = number_format($s1, 2, '.', '');
                    $sub1 = number_format($subPrice1, 2, '.', '');
                    ?>
                    <strong class="text-black">$<?php echo $p1?></strong>
                    <?php 
                  }else{
                    $subPrice1=$subPrice*1.08;
                    $sub1 = number_format($subPrice1, 2, '.', '');
                    ?>
                    <strong class="text-black">$<?php echo $sub1?></strong>
                  <?php }?>
                  </div>
                </div>
                </form>
              <?php 
              if(!empty($cartItems))
              {
              ?>
                <div class="row">
                  <div class="col-md-12">
                      <a href="#" class="btn btn-primary btn-lg py-3 btn-block" id="checkout-button" >Proceed To Checkout</a>
                  </div>
              </div>
              <?php }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- The modal dialog -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModal">&times;</span>
              <form id="payment-form" action="cart.php" method="POST" onsubmit="return validatePayment();">
                        <!-- The two checkboxes -->
                        <div class="radio-container">
                            <label class="radio-label">
                                <div class="custom-radio" id="custom-radio-cash"></div>
                                <input type="radio" name="payment-option" id="cash-on-delivery" onclick="hidePaymentFields()">
                                Cash on Delivery
                            </label>
                        </div>
                        <div class="radio-container">
                            <label class="radio-label">
                                <div class="custom-radio" id="custom-radio-card"></div>
                                <input type="radio" name="payment-option" id="card-payment" onclick="showPaymentFields()">
                                Card Payment
                            </label>
                        </div>
                  <!-- Payment fields are contained within a div with an ID for easier control -->
                  <div id="form-container" style="height: 400px; overflow: auto;">
                    <div id="payment-fields" class="payment-fields"> 
                        <h1 style="color: #7971ea; font-size: 24px; text-transform: uppercase; text-align: center; margin: 20px 0;">
                            <b>Online Payment</b>
                        </h1>
                        <div class="form-group">
                            <label for="card-number">Card Number</label>
                            <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" oninput="formatCardNumber(this);">
                        </div>
                        <div class="form-group">
                            <label for="cardholder-name">Cardholder Name</label>
                            <input type="text" id="cardholder-name" name="cardholder-name" placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label for="expiration-date">Expiration Date</label>
                            <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/YY" oninput="formatExpirationDate(this);">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" oninput="formatCVV(this);">
                        </div>
                        <div class="form-group">
                            <label for="billing-address">Billing Address</label>
                            <input type="text" id="billing-address" name="billing-address" required>
                        </div>
                        <div class="form-group">
                            <label for="postal-code">Postal Code</label>
                            <input type="text" id="postal-code" name="postal-code" required>
                        </div>
                        <button  name="pay" class="submit-button"  onclick="return confirm('Are you sure that you want to proceed???')">Submit Payment</button>
                    </div>
              </form>
                <div id="card-fields" class="card-fields"> 
                <h1 style="color: #7971ea; font-size: 24px; text-transform: uppercase; text-align: center; margin: 20px 0;">
                  <b>Cash on Delivery</b>
              </h1>
              <form action="cart.php" method="POST">
                    <div class="form-group">
                        <label for="billing-address">Billing Address</label>
                        <input type="text" id="billing-address" name="billing-address" required>
                    </div>
                    <div class="form-group">
                        <label for="postal-code">Postal Code</label>
                        <input type="text" id="postal-code" name="postal-code" required>
                    </div>
                    <button name="cashPay" class="submit-button" onclick="return confirm('Are you sure that you want to proceed???')">Submit Payment</button>
                </div>
              </form>
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
    
  </body>

  <script>

document.getElementById('checkout-button').addEventListener('click', function() {
    var modal = document.getElementById('myModal');
    var confirmButton = document.getElementById('confirmCheckout');
    var closeButton = document.getElementById('closeModal');

    // Show the modal
    modal.style.display = 'block';

    // Close the modal if the user clicks the close button
    closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close the modal if the user clicks outside the modal
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Handle the user's confirmation to proceed to checkout
    confirmButton.addEventListener('click', function() {
        // Add your checkout logic here
        alert('Checkout confirmed!'); // Replace this with your actual checkout process
        modal.style.display = 'none';
    });
});

function validatePayment() {
    var cardNumber = document.getElementById("card-number").value;
    var cardholderName = document.getElementById("cardholder-name").value;
    var expirationDate = document.getElementById("expiration-date").value;
    var cvv = document.getElementById("cvv").value;

    // Card number format: 16 digits, with or without spaces
    var cardNumberPattern = /^(\d{4}\s?\d{4}\s?\d{4}\s?\d{4}|\d{16})$/;
    if (!cardNumber.match(cardNumberPattern)) {
        alert("Invalid card number format.");
        return false;
    }

    // Cardholder name format: Only letters, space, and apostrophe
    var cardholderNamePattern = /^[A-Za-z\s']+$/;
    if (!cardholderName.match(cardholderNamePattern)) {
        alert("Invalid cardholder name format.");
        return false;
    }

    // Expiration date format: MM/YY
    var expirationDatePattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
    if (!expirationDate.match(expirationDatePattern)) {
        alert("Invalid expiration date format. Use MM/YY format.");
        return false;
    }

    // CVV format: 3 digits
    var cvvPattern = /^\d{3}$/;
    if (!cvv.match(cvvPattern)) {
        alert("Invalid CVV format. Use 3 digits.");
        return false;
    }

    // All fields are valid
    return true;
}

  function formatCardNumber(input) {
    // Remove any non-digit characters
    var cardNumber = input.value.replace(/\D/g, '');
    
    // Limit the card number to 16 digits
    if (cardNumber.length > 16) {
        cardNumber = cardNumber.slice(0, 16);
    }
    
    // Add spaces every 4 digits
    cardNumber = cardNumber.replace(/(\d{4})(?=\d)/g, '$1 ');
    
    // Update the input value
    input.value = cardNumber;
}

function formatExpirationDate(input) {
    var value = input.value.replace(/\D/g, ''); // Remove non-digit characters
    
    // Ensure the value is exactly 4 digits with a "/"
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }
    
    // Limit to 4 digits with a "/"
    if (value.length > 5) {
        value = value.slice(0, 5);
    }
    
    input.value = value;
}

function formatCVV(input) {
    var value = input.value.replace(/\D/g, ''); // Remove non-digit characters
    
    // Limit to 3 digits
    if (value.length > 3) {
        value = value.slice(0, 3);
    }
    
    input.value = value;
}
</script>
<script src="js/add.js"></script>


</html>