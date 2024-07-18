

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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      
      <!-- pop out message design-->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">

   </head>



   <?php


session_start();
include "../object/database.php";
include "../object/verification.php";

$Login = new Login("localhost", "user", "password", "finalproject");
$verification= new Verification();

$Oid = isset($_SESSION["Oid"]) ? $_SESSION["Oid"] : "";
$discount=$Login->getDiscount($Oid);

$offerErr = "";
$percentErr = "";


// Check if the form is submitted
if (isset($_POST["submit"])) {
    $offer = isset($_POST["offer"]) ? $_POST["offer"] : "";
    $available = isset($_POST["available"]) ? $_POST["available"] : "";
    $date = isset($_POST["date"]) ? $_POST["date"] : "";
    $userID=isset($_POST["userID"])?$_POST["userID"]:"";
    $percentage = isset($_POST["percentage"]) ? $_POST["percentage"] : "";

    $percentErr = $verification->percent($percentage);
    $offerErr = $verification->offer($offer);

      // Check if a file was uploaded
    if (empty($percentErr) && empty($offerErr) && $userID && $date && $available) {
        // Update the user data in the database without handling image
        $Login->updateDiscount($Oid,$offer, $percentage, $userID,$available,$date);
    }
    else
    {

      
    }
    
}


?>

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
                                       <a class="dropdown-item" href="../Logout/logout.php"><span>Log Out</span> <i class="fas fa-sign-out-alt" style='color:rgb(40, 140, 228)'></i></a>
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
                              <h2> Discount</h2>
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
                                    <h2>Edit Discount</h2>
                                 </div>
                              </div>
                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                    <!-- user profile section --> 
                                    <!-- profile image -->
                                    <form action="admin_show_discount_edit.php" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-12">
                                       <div class="full dis_flex center_text">
                                         
                                        <div class="profile_contant">
                                            <div class="contact_inner">

                                             <br><label for="offer">Offer</label><br>
                                             <input type="text" name="offer" value="<?php echo $discount["offer"]?>"><br>
                                             <?php
                                             if ($offerErr == "") {
                                                // If the error is empty, this row does not appear
                                    
                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $offerErr; ?></b></span><br>
                                             <?php
                                             }     
                                             ?>
                                             <br><label for="percentage">Percentage</label><br>
                                             <input type="text" name="percentage" value="<?php echo $discount["percentage"]?>"><br>
                                             <?php
                                             if ($percentErr == "") {
                                                // If the error is empty, this row does not appear
                                    
                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $percentErr; ?></b></span><br>
                                             <?php
                                             }     
                                             ?>

                                             <br><label for="userID">userID</label><br>
                                             <input type="text" name="userID" value="<?php echo $discount["userID"]?>" require><br>

                                             <label for="available">Available status</label><br>
                                             <select name="available" require>
                                                <option value="Available" <?php echo $discount["available"] == 1 ? 'selected' : ''; ?>>Available</option>
                                                <option value="Unavailable" <?php echo $discount["available"] == 0 ? 'selected' : ''; ?>>Unavailable</option>
                                             </select><br>


                                             <br><label for="date">Date</label><br>
                                             <input type="date" name="date" value="<?php echo $discount["date"] ?>"require><br>

                                             <div class="right_button">
                                                <br><br><br><button type="submit" class="btn btn-success btn-xs" name="submit" onclick="return confirm('Are you sure that you want to save changes?')">Save Changes</button>
                                             </div>
                                             
                                             </form>
                                             </div>
                                          </div>
                                       </div>                                    
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
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>

   </body>
</html>