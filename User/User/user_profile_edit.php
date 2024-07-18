<?php

session_start();
include "../object/database.php";
include "../object/sendPic.php";
include "../object/verification.php";

$Login = new Login("localhost", "user", "password", "finalproject");
$verification = new Verification();

$userID = isset($_SESSION["userID"]) ? $_SESSION["userID"] : "";

$nameErr = "";
$mailErr = "";
$errorMsg="";

$user = $Login->getUserDetail($userID);
$email = !empty($_POST["Email"]) ? $_POST["Email"] : "";
$emailChan = !empty($_POST["emailChan"]) ? $_POST["emailChan"] : "";
$name = isset($_POST["Name"]) ? $_POST["Name"] : "";

// Check if the form is submitted
if (isset($_POST["submit"])) {
   $Email = isset($_POST["Email"]) ? $_POST["Email"] : "";
   $Name = isset($_POST["Name"]) ? $_POST["Name"] : "";

   $nameErr = $verification->ErrorName($Name);
	$mailErr = $verification->Errorm($Email);
	   
   if (empty($nameErr) && empty($mailErr)) {
      // Check if a file was uploaded
      if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
          $FileUploader = new FileUploader($_FILES);
          $Image = $uploadMessage = $FileUploader->uploadPicUser();
          // Update the user data in the database
          if($emailChan!=$Email)
          {
            $email1 = new email();
            $email1->sendUpdatedUserDetailsEmail($Email);
            $Login->isEmailExists($userID,$Name,$Image,$Email); 
            
          }
          else
          {
            $email1 = new email();
            $email1->sendUpdatedUserDetailsEmail($Email);
            $Login->updateuserdetails($userID,$Name,$Image,$Email);
          }

      } else 
      {
          $Image = $user["Image"]; // Retain the existing image if no file was uploaded
          // Update the user data in the database
          if($emailChan!=$Email)
          {
            $email1 = new email();
            $email1->sendUpdatedUserDetailsEmail($Email);
            $Login->isEmailExists($userID,$Name,$Image,$Email);

          }
          else
          {
            $email1 = new email();
            $email1->sendUpdatedUserDetailsEmail($Email);
            $Login->updateuserdetails($userID,$Name,$Image,$Email);
          }


      }
      // Check if there's an error message
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
      <link rel="icon" href="images/fevicon.png" type="image/png" />
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
                  <li><a href="../Mainpage/index-2.php"><i class="fa fa-home red_color"></i> <span>Home</span></a></li>
                     <li><a href="profile.php"><i class="fa fa-diamond purple_color"></i> <span>My Profile</span></a></li>
                     <li><a href="checkTicket.php"><i class="fa fa-dashboard yellow_color"></i> <span>My Tickets</span></a></li>
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
                                 <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="../Admin/image/user/<?php echo $user["Image"]?>" alt="#" /><span class="name_user"><?php echo $user["Name"]; ?></span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="../Mainpage/index-2.php">Home <i class="fa fa-home red_color"></i></a>
                                       <a class="dropdown-item" href="profile.php">My Profile <i class="fa fa-diamond purple_color"></i></a>
                                       <a class="dropdown-item" href="forgot/forgot.php">Change Password <i class="fa fa-lock green_color"></i></a>
                                       <a class="dropdown-item" href="../Logout/logout.php">Log Out <i class="fa fa-sign-out" style='color:rgb(40, 140, 228)'></i></a>
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
                              <h2>Profile</h2>
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
                                    <h2>User Profile</h2>
                                 </div>
                              </div>
                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                    <!-- user profile section --> 
                                    <!-- profile image -->
                                    <form action="user_profile_edit.php" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-12">
                                       <div class="full dis_flex center_text">
                                          <div class="profile_img">
                                             <img width="180" class="rounded-circle" src="../Admin/image/user/<?php echo $user["Image"]?>" alt="#" /><br>
                                             <!-- File upload button -->
                                                <input type="file" style="margin-top:20px;"  id="fileUpload" name="file" ><br>
                                             
                                          </div>
                                          <div class="profile_contant">
                                             <div class="contact_inner">
                                             <label for="name">Name</label><br>
                                             <input type="text" name="Name" value="<?php echo $user["Name"]; ?>"><br>
                                             <?php                                              
                                             if ($nameErr == "") {
                                                // If the error is empty, this row does not appear
                                    
                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $nameErr; ?></b></span><br>
                                             <?php }
                                                ?>

                                             <br><label for="Email">Email</label><br>
                                             <input type="text" name="Email" value="<?php echo $user["Email"]; ?>"><br>
                                             <input type="hidden" name="emailChan" value="<?php echo $user["Email"]; ?>">
                                             <?php
                                             if ($mailErr == "") {
                                                // If the error is empty, this row does not appear

                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $mailErr; ?></b></span><br>
                                             <?php
                                             }
                                             ?>
                                             <?php
                                             if ($errorMsg == "") {
                                                // If the error is empty, this row does not appear

                                             } else {
                                                // If the error is not empty, display the error message
                                                ?>
                                                <span style="color:red;"><b><?php echo $errorMsg; ?></b></span><br>
                                             <?php
                                             }
                                             ?>
                                    

                                             <div class="right_button">
                                             <br><br><br><button type="submit" class="btn btn-success btn-xs" name="submit" onclick="return confirm('Are you sure that you want to change?')">Save Changes</button>
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