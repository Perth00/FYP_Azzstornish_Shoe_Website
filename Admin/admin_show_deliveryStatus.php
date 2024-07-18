<?php
   session_start();
   include "../object/database.php";
   include "../object/database2.php";

   $Login = new Login("localhost","user","password","finalproject");
   $Login2 = new Login2("localhost","user","password","finalproject");
   $email2 = new email2();
   $purchaseID = isset($_SESSION["purchaseID"]) ? $_SESSION["purchaseID"] : "";
   $userID = isset($_SESSION["userID"]) ? $_SESSION["userID"] : "";

   $statusDelivery=[];
   $statusDelivery=$Login2->getDeliveryStatus($purchaseID);
   $status=$statusDelivery["status"];
   $_SESSION["current_status"] = $status;

   $user=$Login->getUser($userID);

   $email=$user["Email"];
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $status = $_POST["status"];
       // Store the current status in a session variable
       $_SESSION["current_status"] = $status;
       $Login2->UpdatedelivertStatus($purchaseID,$status);
       unset($_SESSION["purchaseID"]);
       $email2->sendDeliveryStatusEmail($email, $status);
       echo "<script>
       alert('Update Delivery Status successfully!!!');
       window.location.href = 'admin_show_purchase.php';
       </script>";
   }

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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   </head>
   <style>


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
</style>
   <body class="inner_page profile_page">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="UserInfo.php"><img class="logo_icon img-responsive" src="../User/images/logo/logo_black.jpeg" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="image/user-account-avatar-icon-pictogram-260nw-1860375778.webp" alt="#" /></div>
                        <div class="user_info">
                           <h6>Admin</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                  <li><a href="../shoppers-gh-pages/index.php"><i class="fa fa-home red_color"></i> <span>Home</span></a></li>
                     <li><a href="UserInfo.php"><i class="fa fa-table purple_color2"></i> <span>User Info</span></a></li>
                     <li><a href="admin_statistic_details.php"><i class="fa fa-bar-chart yellow_color"></i> <span>Statistics</span></a></li> 
                     <li><a href="admin_show_purchase.php"><i class="fas fa-receipt" style="color: #75ff85;"></i></i><span>Purchase History</span></a></li>
                     <li><a href="admin_show_category.php"><i class="fas fa-layer-group fa-xs" style="color: #71fefc;"></i><span>Category</span></a> </li>
                     <li><a href="admin_show_discount.php"><i class="fas fa-percentage" style="color: #c54cf0;"></i><span>Discount</span></a></li>
                     <li><a href="admin_show_product.php"><i class="fas fa-shopping-cart fa-xs" style="color: #feee86;"></i><span>Product</span></a></li>
                     <li><a href="../Logout/logout.php"><i class="fas fa-sign-out-alt" style='color:rgb(40, 140, 228)'></i> <span>Log Out</span></a></li>
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
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="image/user-account-avatar-icon-pictogram-260nw-1860375778.webp" alt="#" /><span class="name_user">Admin</span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="../Registration/logout.php"><span>Log Out</span> <i class="fas fa-sign-out-alt" style='color:rgb(40, 140, 228)'></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->
               <!-- profile inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Purchase Status</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row column1">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Delivery Status</h2>
                                 </div>
                              </div>
                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                             <div class="tracking" style="margin-left:200px;">
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
                                             <div class="controls"  style="margin-left:200px;">
                                             <div>
                                             <form id="statusForm" method="POST" action="admin_show_deliveryStatus.php">
                                                <input type="hidden" id="statusInput" name="status" value="Order Processed">
                                                </form>
                                                <button id="prev"><i class='bx bx-chevron-left' onclick="return confirm('Are you sure that you want to go back the previous delivery')"></i> Prev</button>
                                                <button id="next" onclick="return confirm('Are you sure that you want to update the delivery status??')">Next <i class='bx bx-chevron-right'></i></button>
                                             </div>
                                             <div>
                                                <p><span id="step" style="display:none;"></span></p>
                                             </div>
                                          </div>
                                    </div>
                                 </div>
                                 <div class="col-md-2"></div>
                              </div>
                              <!-- end row -->
                     </div>
                     <!-- footer -->
                     <div class="container-fluid">
                        <div class="footer">
                           <p>Copyright © 2023. All rights reserved.<br><br>
                           </p>
                        </div>
                     </div>
                  </div>
                  <!-- end dashboard inner -->
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
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