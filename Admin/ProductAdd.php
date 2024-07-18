<?php

include "../object/database.php";
include "../object/sendPic.php";
include "../object/verification.php";

$Login = new Login("localhost", "user", "password", "finalproject");
$pNameErr = "";
$priceErr="";
$seriesErr="";
$category = [];
$category = $Login->showCategory();

// Check if the form is submitted
if (isset($_POST["submit"])) {
   $pName = isset($_POST["pName"]) ? $_POST["pName"] : "";
   $price = isset($_POST["price"]) ? $_POST["price"] : "";
   $size =  isset($_POST["size"]) ? $_POST["size"]: "";
   $image = isset($_POST["image"]) ? $_POST["image"]: "";
   $details = isset($_POST["details"]) ? $_POST["details"]: "";
   $quantity = isset($_POST["qty"]) ? $_POST["qty"]: "";
   $status = isset($_POST["status"]) ? $_POST["status"]: "";
   $color = isset($_POST["color"]) ? $_POST["color"]: "";
   $series = isset($_POST["series"]) ? $_POST["series"] : "";
   $category = isset($_POST["category"]) ? $_POST["category"] : "";
   $video = isset($_POST["video"]) ? $_POST["video"] : "";

   $reg = new Verification();

   $pNameErr = $reg->pName($pName);
   $priceErr = $reg->price($price);
   $seriesErr = $reg->ErrorName($series);


      // Check if a file was uploaded
   if(empty($pNameErr) AND empty($priceErr) AND empty($seriesErr))
   {   
      if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
          $FileUploader = new FileUploader($_FILES);
          $image = $uploadMessage = $FileUploader->uploadProductPicAdmin();
          // Update the user data in the database
          $Login->addProduct($pName,$series,$image,$size,$price,$details,$quantity,$status,$color,$category,$video);
      } 
      else 
      {
          $image = "shoes"; // Retain the existing image if no file was uploaded
          // Update the user data in the database
          $Login->addProduct($pName,$series,$image,$size,$price,$details,$quantity,$status,$color,$category,$video);
      }
   }
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   </head>
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
                              <h2>Add Product</h2>
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
                                    <h2>Add Product</h2>
                                 </div>
                              </div>
                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                    <!-- user profile section --> 
                                    <!-- profile image -->
                                    <form action="ProductAdd.php" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-12">
                                       <div class="full dis_flex center_text">
                                          <div class="profile_img">
                                             <img width="180" class="rounded-circle" src="../Admin/image/user/images.png" alt="#" /><br>
                                             <!-- File upload button -->
                                                <input type="file" style="margin-top:20px;"  id="fileUpload" name="file" ><br>                                            
                                        </div>

                                        <div class="profile_contant">
                                            <div class="contact_inner">

                                             <br><label for="pName">Product Name</label><br>
                                             <input type="text" name="pName" value=""><br>
                                             <?php
                                             if ($pNameErr == "") {
                                                // If the error is empty, this row does not appear
                                    
                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $pNameErr; ?></b></span><br>
                                             <?php
                                             }     
                                             ?>
                                             <br><label for="productSeries">Product Series</label><br>
                                             <input type="text" name="series" value=""><br>
                                             <?php
                                             if ($seriesErr == "") {
                                                // If the error is empty, this row does not appear
                                    
                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $seriesErr; ?></b></span><br>
                                             <?php
                                             }     
                                             ?>

                                             <br><label for="price">Price</label><br>
                                             <input type="text" name="price" value=""><br>
                                             <?php
                                             if ($priceErr == "") {
                                                // If the error is empty, this row does not appear
                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $priceErr; ?></b></span><br>
                                             <?php
                                             }
                                             ?>
                                             <br><label for="size">Size</label><br>
                                             <input type="text" name="size" value="" required   ><br><br>
                                             <br><label for="video">Video</label><br>
                                             <input type="text" name="video" value="" required ><br><br>
                                             <label for="color">Color</label><br>
                                             <input type="text" name="color" value="" required><br>
                                             <br><label for="size">Quantity</label><br>
                                             <input type="number" name="qty" min="1" max="50" required><br>                                      
                                             <br><label for="size">Details</label><br>
                                             <textarea name="details" value="" rows="15"cols="40" required></textarea><br><br>  
                                             <label for="status">Status</label><br>
                                             <select name="status" required>
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Top">Top</option>
                                                <option value="Sales">Sales</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Popular">Popular</option>
                                             </select><br><br>  
                                             <label for="category">Category</label><br>
                                             <select name="category" required>
                                                <?php 
                                                foreach($category as $category)
                                                {
                                                
                                                ?>
                                                <option value="<?php echo $category["cName"]?>" ><?php echo $category["cName"]?></option>
                                                <?php }?>
                                             </select><br>


                                            <div class="right_button">
                                            <br><br><br><button type="submit" class="btn btn-success btn-xs" name="submit" onclick="return confirm('Are you sure you want to save changes?')">Add</button>
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