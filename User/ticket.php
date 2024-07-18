<?php
session_start();

include "../object/database.php";
include "../object/database2.php";

include "../object/login.php";
include '../phpqrcode/qrlib.php';
$Login2 = new Login2("localhost", "user", "password", "finalproject");

   $Login = new Login("localhost", "user", "password", "finalproject");
   $userID = isset($_SESSION["userID"]) ? $_SESSION["userID"] : "";
   $user = $Login->getUserDetail($userID);
   $amount = $Login2->getUserTotal($userID);



   $purchaseID = isset($_SESSION["purchaseID"]) ? $_SESSION["purchaseID"] : "";
   $purchaseTime = isset($_SESSION["purchaseTime"]) ? $_SESSION["purchaseTime"] : "";
   $item = isset($_SESSION["item"]) ? $_SESSION["item"] : "";
   $price = isset($_SESSION["price"]) ? $_SESSION["price"] : "";
   $totalPrice = isset($_SESSION["totalPrice"]) ? $_SESSION["totalPrice"] : "";

   $qty = isset($_SESSION["qty"]) ? $_SESSION["qty"] : "";
   $payMethod = isset($_SESSION["payMethod"]) ? $_SESSION["payMethod"] : "";
   $userID = isset($_SESSION["userID"]) ? $_SESSION["userID"] : "";
   $qr = isset($_SESSION["qr"]) ? $_SESSION["qr"] : "";


   $purchase = $Login2->getQr($purchaseID);
   $receipt=$Login2->showReceipt($purchaseID);
   $user=$Login->getUserDetail($userID);
   $totalFinalprice=0;


    $statusDelivery=$Login2->getDeliveryStatus($purchaseID);
    $status = $statusDelivery["status"];
    // Store the current status in a session variable
    $_SESSION["current_status"] = $status;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- site icon -->
    <link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- site css -->
    <link rel="stylesheet" href="style.css" />
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- color css -->
    <link rel="stylesheet" href="css/colors.css" />
    <!-- select bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
/* vars */
:root {
--back: #eeeeee;
--blue: #0082d2;
--green: #33DDAA;
--gray: #777777;
--size: 200px;  
}

body, html {
background: var(--back);
padding: 0;
margin: 0;
font-family: sans-serif;
color: var(--gray);
}
.tracking-wrapper {
margin: 30px;
padding: 0;
}
.tracking * {
padding: 0;
margin: 0;
}
.tracking {
width: var(--size);
max-width: 100%;
position: relative;
}
.tracking .empty-bar {
background: #ddd;
position: absolute;
width: 90%;
height: 20%;
top: 40%;
margin-left: 5%;
}
.tracking .color-bar {
background: var(--blue);
position: absolute;
height: 20%;
top: 40%;
margin-left: 5%;
transition: all 0.5s;
-webkit-transition: all 0.5s;
-moz-transition: all 0.5s;
-ms-transition: all 0.5s;
-o-transition: all 0.5s;
}
.tracking ul {
display: flex;
justify-content: space-between;
list-style: none;
}
.tracking ul > li {
background: #ddd;
text-align: center;
border-radius: 50%;
-webkit-border-radius: 50%;
-moz-border-radius: 50%;
-ms-border-radius: 50%;
-o-border-radius: 50%;
z-index: 1;
background-size: 70%;
background-repeat: no-repeat;
background-position: center center;
transition: all 0.5s;
-webkit-transition: all 0.5s;
-moz-transition: all 0.5s;
-ms-transition: all 0.5s;
-o-transition: all 0.5s;
display: inline-block;
position: relative;
width: 10%;
}
.tracking ul > li .el {
position: relative;
margin-top: 100%;
}
.tracking ul > li .el i {
position: absolute;
bottom: 100%;
left: 8%;
margin-bottom: 12%;
color: #fff;
font-size: 100%;
display: none;
}
.tracking ul > li .txt {
color: #999;
position: absolute;
top: 120%;
left: -75%;
text-align: center;
width: 250%;
font-size: .75rem;
}
.tracking .progress-0 .color-bar { width: 00%; }
.tracking .progress-1 .color-bar { width: 30%; }
.tracking .progress-2 .color-bar { width: 60%; }
.tracking .progress-3 .color-bar { width: 90%; }
.tracking .progress-4 .color-bar { width: 90%; }

.tracking .progress-0 > ul > li.bullet-1,
.tracking .progress-1 > ul > li.bullet-1,
.tracking .progress-2 > ul > li.bullet-1,
.tracking .progress-3 > ul > li.bullet-1,
.tracking .progress-4 > ul > li.bullet-1
{ background-color: var(--blue); }

.tracking .progress-1 > ul > li.bullet-2,
.tracking .progress-2 > ul > li.bullet-2,
.tracking .progress-3 > ul > li.bullet-2,
.tracking .progress-4 > ul > li.bullet-2
{ background-color: var(--blue); }

.tracking .progress-2 > ul > li.bullet-3,
.tracking .progress-3 > ul > li.bullet-3,
.tracking .progress-4 > ul > li.bullet-3
{ background-color: var(--blue); }


.tracking .progress-3 > ul > li.bullet-4,
.tracking .progress-4 > ul > li.bullet-4    
{ background-color: var(--blue); }

.tracking .progress-4 > ul > li.bullet-4    
{ background-color: var(--green); }

.tracking .progress-1 > ul > li.bullet-1 .el i,
.tracking .progress-2 > ul > li.bullet-1 .el i,
.tracking .progress-3 > ul > li.bullet-1 .el i,
.tracking .progress-4 > ul > li.bullet-1 .el i
{ display: block; }

.tracking .progress-2 > ul > li.bullet-2 .el i,
.tracking .progress-3 > ul > li.bullet-2 .el i,
.tracking .progress-4 > ul > li.bullet-2 .el i
{ display: block; }

.tracking .progress-3 > ul > li.bullet-3 .el i,
.tracking .progress-4 > ul > li.bullet-3 .el i
{ display: block; }

.tracking .progress-4 > ul > li.bullet-4 .el i
{ display: block; }

.tracking .progress-1 > ul > li.bullet-1 .txt,
.tracking .progress-2 > ul > li.bullet-1 .txt,
.tracking .progress-3 > ul > li.bullet-1 .txt
{ color: var(--blue); }

.tracking .progress-2 > ul > li.bullet-2 .txt,
.tracking .progress-3 > ul > li.bullet-2 .txt,
{ color: var(--blue); }

.tracking .progress-3 > ul > li.bullet-3 .txt,
{ color: var(--blue); }


/* demo */
.controls {
margin: 90px 30px 30px;
display: flex;
flex-direction: column;
justify-content: flex-start;
align-items: flex-start;
}
.controls > div {
display: flex;
justify-content: flex-start;
align-items: space-between;
margin: 0;
padding: 0;
}
.controls p,
.controls button {
border: 0;
line-height: 20px;
padding: 15px;
font-size: 0.8rem;
text-transform: uppercase;
}
.controls button {
display: flex;
justify-content: space-between;
align-items: center;
margin: 0 6px;
background: var(--blue);
color: #fff;
border-radius: 50px;
transition: all .3s;
}
.controls button:nth-child(1) {
margin-left: 0;
}
.controls button i {
font-size: 1rem;
margin: 0 5px;
}
.controls button#prev { padding-right: 30px; }
.controls button#next { padding-left: 30px; }

.controls button:hover,
.controls button:focus {
outline: none;
background-color: var(--green);
}


        body {
            background: rgba(0,0,0,0.4);
    color: #3a3e59;
    font-family: "Raleway", Arial, sans-serif;
    }

    .close-button {
  background-color: red;
  border: none;
  font-size: 24px;
  padding: 10px 20px; /* Adjust padding as needed */
  cursor: pointer;
  outline: none;    
  margin-left:300px;
  
}

.close-button:hover {
  background-color: #f2f2f2; /* Change color on hover if desired */
}

            /* Login Popup CSS */
            .login-area {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
            display: none;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 99;
            padding: 0 15px;
        }

        .login-box {
            max-width: 380px;
            background: transparent;
            position: relative;
            color: #03090e;
            margin: 200px auto 100px auto;
            padding: 40px 25px 25px;
        }

        .login-box a {
            color: #03090e;
        }

        .login-box > a {
            position: absolute;
            right: 0;
            top: 0;
            background: #eb315a;
            font-size: 22px;
            color: #fff;
            width: 35px;
            height: 35px;
            text-align: center;
            line-height: 35px;
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
<body class="inner_page profile_page">
<div class="full_container">
    <div class="inner_container">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar_blog_1">
                <div class="sidebar-header">
                    <div class="logo_section">
                    <a href="profile.php"><img class="logo_icon img-responsive" src="../User/images/logo/logo_black.jpeg" alt="#" /></a>
                    </div>
                </div>
                <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="../Admin/image/user/<?php echo $user["Image"]?>" alt="#" /></div>
                        <div class="user_info">
                           <h6><?php echo $user["Name"]; ?><?php echo " ";?></h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
            <div class="sidebar_blog_2">
                <h4>General</h4>
                <ul class="list-unstyled components">
                <li><a href="../shoppers-gh-pages/index.php"><i class="fa fa-home red_color"></i> <span>Home</span></a></li>
                     <li><a href="profile.php"><i class="fa fa-diamond purple_color"></i> <span>My Profile</span></a></li>
                     <li><a href="checkTicket.php"><i class="fa fa-dashboard yellow_color"></i> <span>My Purchase</span></a></li>
                     <li><a href="contact.php"><i class="fa fa-phone yellow_color"></i><span>Contact Us</span></a></li>
                     <li><a href="../Logout/logout.php"><i class="fa fa-sign-out" style='color:rgb(40, 140, 228)'></i> <span>Log Out</span></a></li>
                </ul>
            </div>
        </nav>
    <!-- end sidebar -->
    <!-- right content -->
    <div id="content">
        <!-- topbar -->
        <div class="topbar">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="full">
                    <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                    <div class="right_topbar">
                        <div class="icon_info">
                            <ul class="user_profile_dd">
                                <li>
                                <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="../Admin/image/user/<?php echo $user["Image"]?>" alt="#" /><span class="name_user"><?php echo $user["Name"]; ?><?php echo " ";?></span></a>
                                    <div class="dropdown-menu">
                                       <form action="profile.php" method="post">
                                          <a class="dropdown-item" href="../shoppers-gh-pages/index.php">Home <i class="fa fa-home red_color"></i></a>
                                          <a class="dropdown-item" href="profile.php">My Profile <i class="fa fa-diamond purple_color"></i></a>
                                          <a class="dropdown-item" href="forgot/forgot.php">Change Password <i class="fa fa-lock green_color"></i></a>
                                          <a class="dropdown-item" href="../Logout/logout.php">Log Out <i class="fa fa-sign-out" style='color:rgb(40, 140, 228)'></i></a>
                                       </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- end topbar -->

        <!-- dashboard inner -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Invoice</h2>
                        </div>
                    </div>
                </div>
                <!-- row -->                
                    <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                            <div class="full graph_head">
                                <div class="heading1 margin_0">
                                    <h2><i class="fa fa-file-text-o"></i> Invoice</h2>
                                </div>
                            </div>
                            <div class="full padding_infor_info">
                                <div class="table_row">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>paymentID</th>
                                                    <th>Purchased Date</th>
                                                    <th>item Name</th>
                                                    <th>Delivery status</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <?php
                                                $price=explode("\n", $purchase["price"]);
                                                $totalPrice=explode("\n", $purchase["totalPrice"]);
                                                $item=explode("\n", $purchase["item"]);
                                                $qty=explode("\n", $purchase["qty"]);
                                                ?>
                                                    <td><?php echo $purchase["purchaseID"]?></td>
                                                    <td><?php echo $purchase["purchaseTime"]?></td>
                                                    <td><?php for($i=0;$i<count($price);$i++)
                                                    {
                                                        echo $item[$i]."<br>";
                                                    }?></td>                                                    
      
                                                    <td><?php echo $purchase["status"]?></td>

                                                    <td>
                                                    <div class="right_button">
                                                    <div>
                                                        <button class='btn btn-success btn-xs' onclick="showLoginPopup()" style="margin-right:15px;">Receipt</button>
                                                    </div>
                                                    <div>
                                                        <button class='btn btn-success btn-xs' name="check-status" onclick="openDeliveryStatusModal()" style="margin-top:15px;">Check Delivery Status</button>
                                                    </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <!-- row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="full white_shd">
                            <div class="full graph_head">
                                <div class="heading1 margin_0">
                                    <h2>Payment Methods</h2>
                                </div>
                            </div>
                            <div class="full padding_infor_info">
                                <ul class="payment_option">
                                    <li><img src="images/layout_img/visa.png" alt="#" /></li>
                                    <li><img src="images/layout_img/mastercard.png" alt="#" /></li>
                                    <li><img src="images/layout_img/american-express.png" alt="#" /></li>
                                    <li><img src="images/layout_img/paypal.png" alt="#" /></li>
                                </ul>
                                <p class="note_cont">If you use this site regularly and would like to help keep the site on the Internet.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="deliveryStatusModal" tabindex="-1" role="dialog" aria-labelledby="deliveryStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deliveryStatusModalLabel">Delivery Status</h5>
                        <button type="button" class="close" id="closeButton" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="tracking-wrapper">
                            <div class="tracking">
                            <div id="progress" class="progress-0">
                                <div class="empty-bar"></div>
                                <div class="color-bar"></div>
                                <ul>
                                <li class="bullet-1">
                                    <div class="el"><i class='bx bx-check'></i></div>
                                    <div class="txt">Order Processed</div>
                                </li>
                                <li class="bullet-2">
                                    <div class="el"><i class='bx bx-check'></i></div>
                                    <div class="txt">Order Shipped</div>
                                </li>
                                <li class="bullet-3">
                                    <div class="el"><i class='bx bx-check'></i></div>
                                    <div class="txt">Order En Route</div>
                                </li>
                                <li class="bullet-4">
                                    <div class="el"><i class='bx bx-check'></i></div>
                                    <div class="txt">Order Arrived</div>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        <div class="controls" style="display:none;">
                            <div>
                            <form id="statusForm" method="POST" action="ticket.php">
                                <input type="hidden" id="statusInput" name="status" value="Order Processed">
                            </form>
                            <button id="prev"><i class='bx bx-chevron-left'></i> Prev</button>
                            <button id="next">Next <i class='bx bx-chevron-right'></i></button>
                            </div>
                            <div>
                            <p>Step: <span id="step">0</span></p>
                            </div>
                        </div>
                        </div>

                    <div class="modal-footer">
                    <a href="checkTicket.php" class="btn btn-secondary" id="closeButton">Close</a>
                    </div>
                    </div>
                </div>
                </div>





<!-- Login Popup -->
<div class="login-area" id="login-popup">
    <div class="login-box">
    <button class="close-button" onclick="hideLoginPopup()">&times;</button>
        <div class="receipt" style="margin:-40px;">
                <?php 
            $item="";
            $price="";
            $qty="";
            $totalPrice="";
            $totalFinalprice=0;

            $item=explode("\n", $receipt["item"]);
            $price=explode("\n", $receipt["price"]);
            $qty=explode("\n", $receipt["qty"]);
            $totalPrice=explode("\n", $receipt["totalPrice"]);
            $n=count($item);
            $c=0;
            for($i = 0; $i < $n; $i++)
            {
                $c+=$qty[$i];
            }
        ?>  	
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
            <img src="../shoppers-gh-pages/<?php echo $receipt["qr"]?>" alt="Your QR Code Image">
            </div>
        </footer>
    </div>
    </div>
</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- bootstrap -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- slimscroll -->
<script src="js/jquery.slimscroll.js"></script>
<!-- custom -->
<script src="js/custom.js"></script>

<script>
  // Get a reference to the "Close" button
  var closeButton = document.getElementById("closeButton");

  // Add a click event listener to the "Close" button
  closeButton.addEventListener("click", function() {
    // Use window.location.href to navigate to the checkTicket.php page
    window.location.href = "checkTicket.php";
  });
</script>

<script>
    function showLoginPopup() {
        document.getElementById("login-popup").style.display = "block";
    }

    function hideLoginPopup() {
        document.getElementById("login-popup").style.display = "none";
        window.location.href = "checkTicket.php";

    }

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

<script>
  function openDeliveryStatusModal() {
    $('#deliveryStatusModal').modal('show');
    // You can load and update the delivery status content dynamically here.
  }
</script>

<script>
    var prev = document.getElementById('prev');
    var next = document.getElementById('next');
    var trak = document.getElementById('progress');
    var step = document.getElementById('step');

    next.addEventListener('click', function () {
        var cls = trak.className.split('-').pop();
        cls > 6 ? cls = 0 : cls++;

        step.innerHTML = cls;
        trak.className = 'progress-' + cls;

        // Update the status input field
        var statusInput = document.getElementById('statusInput');
        statusInput.value = getStatusText(cls);

        // Submit the form
        document.getElementById('statusForm').submit();
    });

    prev.addEventListener('click', function () {
        var cls = trak.className.split('-').pop();

        // Check if there's a previous status stored in the session
        if (cls > 0) {
            cls--;
        }

        step.innerHTML = cls;
        trak.className = 'progress-' + cls;

        // Update the status input field
        var statusInput = document.getElementById('statusInput');
        statusInput.value = getStatusText(cls);

        // Submit the form
        document.getElementById('statusForm').submit();
    });

    function getStatusText(cls) {
    switch (cls) {
        case 0:
            return 'Order Processed';
        case 1:
            return 'Order Shipped';
        case 2:
            return 'Order En Route';
        case 3:
            return 'Order Arrived';
        default:
            return 'Order Processed';
    }
}

    // Initialize the status and form
    document.addEventListener('DOMContentLoaded', function () {
        var initialStatus = "<?php echo isset($_SESSION['current_status']) ? $_SESSION['current_status'] : 'Order Processed'; ?>";
        var initialStep = getStatusStep(initialStatus);
        step.innerHTML = initialStep;
        trak.className = 'progress-' + initialStep;
        var statusInput = document.getElementById('statusInput');
        statusInput.value = initialStatus;
    });

    function getStatusStep(status) {
        switch (status) {
            case 'Order Processed':
                return 0;
            case 'Order Shipped':
                return 1;
            case 'Order En Route':
                return 2;
            case 'Order Arrived':
                return 3;
            default:
                return 0;
        }
    }
    </script>
</body>
</html>
