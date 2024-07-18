<?php
   session_start();
   include "adminclasses/dbcon.php";
   include "../object/database.php";

   $Login = new Login("localhost","user","password","finalproject");

   $purchase = isset($_SESSION["purchaseID"]) ? $_SESSION["purchaseID"] : "";

   if(isset($_POST["delete"]))
   {
      $purchase=!empty($_POST["purchaseID"])?$_POST["purchaseID"]:"";
      $Login-> deletePurchase($purchase);
      echo "<script>
      alert('Delete successfully!!!');
      window.location.href = 'admin_show_purchase.php';
      </script>"; // Redirect to the desired page after deletion
   }
   if(isset($_POST["update"]))
   {
      $purchaseID = $_POST["purchaseID"];
      $userID = $_POST["userID"];
      $_SESSION["purchaseID"] = $purchaseID;
      $_SESSION["userID"] = $userID;

      header("location: admin_show_deliveryStatus.php");
   }
   $title = !empty($_POST["title"]) ? str_replace(" ", "", $_POST["title"]) : "";
   $filter=!empty($_POST["filter"])?$_POST["filter"]:"";

   
   
   // Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "finalproject"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page5'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page5']) && is_numeric($_SESSION['current_page5'])) {
    $page = $_SESSION['current_page5'];
} else {
    $page = 1;
}
// Get the offset value for the SQL query
$offset = ($page - 1) * $records_per_page;


// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM purchase";
$result_total = mysqli_query($conn, $total_query);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];


?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
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
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      
      <style>
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination {
        list-style-type: none;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a {
        display: block;
        padding: 5px 10px;
        background-color: #f1f1f1;
        color: #333;
        text-decoration: none;
        border-radius: 3px;
    }

    .pagination li a.active {
        background-color: #333;
        color: #fff;
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
                              <div class="search">
                                 <i class="fas fa-search" style="color:black;font-size:20px"> Search </i>
                                 <form action="admin_show_purchase.php" method="POST">
                                       <select name="filter"> <!--Filter the result-->   
                                          <option value="purchaseID">Purchase ID</option>
                                          <option value="userID">User ID</option>                                      
                                          <option value="item">Item </option>
                                          <option value="price">Price</option>
                                          <option value="payMethod">Method </option>
                                          <option value="qty">Quantity</option>                                     
                                          <option value="totalPrice">Total Price </option>
                                          <option value="purchaseTime">Time Purchase</option>
                                       </select>
                                       <input type="text" placeholder="Search" name="title">
                                       <button type="submit" name="search" class="search-button">Search</button>
                                    </form>                
                                 </div>
                              </div>
                           </div>
                        </div>
                    
                     <div class="full padding_infor_info">
                        <div class="table_row">
                           <div class="table-responsive">
                              <table class="table table-striped">
                                  <thead>
                                    <tr>
                                       <th>Purchase ID</th>
                                       <th>User ID </th>
                                       <th>User Email </th>
                                       <th>Item </th>
                                       <th>Price</th>
                                       <th>Total Price </th>
                                       <th>Quantity</th>
                                       <th>Method</th>
                                       <th>Time Purchase</th>
                                       <th>Delivery status</th>

                                       <th>Action</th>
                                       
                                    </tr>
                                       </thead>
                                       <tbody>
                                       <?php 
                                                $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                where u.userID=p.userID
                                                LIMIT $offset, $records_per_page";
                                                if (isset($_POST["search"])) 
                                                {                                                    
                                                    // Filter the result based on the search criteria
                                                    if ($filter == "purchaseID") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and purchaseID='$title' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    }
                                                    else if ($filter == "userID") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID, u.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status 
                                                        FROM user u, purchase p
                                                        WHERE u.userID = p.userID
                                                        AND u.userID LIKE '%$title%'
                                                        LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    }  
                                                    else if ($filter == "item") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and item like '%$title%' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    } 
                                                    else if ($filter == "price") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and price like '%$title%' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    } 
                                                    else if ($filter == "totalPrice") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and totalPrice like '%$title%' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    }
                                                    else if ($filter == "qty") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and qty like '%$title%' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    }   
                                                    else if ($filter == "payMethod") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and payMethod like '%$title%' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    } 
                                                                                                        
                                                                                                      
                                                    else if ($filter == "purchaseTime") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                        and purchaseTime like '%$title%' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                               $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                               where u.userID=p.userID LIMIT $offset, $records_per_page";
                                                            }
                                                    }                        
                                                } 
                                                else 
                                                {
                                                    // If no search criteria provided, fetch all records for the given user
                                                    $sql = "SELECT p.purchaseID , p.userID, p.item, p.price, p.totalPrice, p.qty, p.payMethod, p.purchaseTime, u.Email, p.status FROM  user u, purchase p
                                                        where u.userID=p.userID
                                                         LIMIT $offset, $records_per_page";
                                                }
                                                    $result = mysqli_query($Login->conn, $sql);
                                                    $num = mysqli_num_rows($result); // count the number of rows
                                            ?>
                                            
                                       <form action="admin_show_purchase.php" method="post">
                                       <?php
                                       while($purchase = mysqli_fetch_assoc($result)) {                                           
                                       ?>
                                       <tr>
                                          <form action="admin_show_purchase.php" method="post">
                                             <td><?php echo $purchase["purchaseID"]?></td>
                                             <td><?php echo $purchase["userID"]?></td> 
                                             <td><?php echo $purchase["Email"]?></td>
                                             <td><?php echo $purchase["item"]?></td>
                                             <td><?php echo $purchase["price"]?></td>  
                                             <td><?php echo $purchase["totalPrice"]?></td>  
                                             <td><?php echo $purchase["qty"]?></td>  
                                             <td><?php echo $purchase["payMethod"]?></td>   
                                             <td><?php echo $purchase["purchaseTime"]?></td> 
                                             <td><?php echo $purchase["status"]?></td> 

                                             <input type="hidden" value="<?php echo $purchase["userID"]?>" name="userID">      

                                             <input type="hidden" value="<?php echo $purchase["purchaseID"]?>" name="purchaseID">      
                                             <div class="right_button">   
                                             <td>                                                                                                                            
                                             <input type="submit" class="btn btn-danger btn-xs" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; cursor: pointer; width:70px;" value="Delete" name="delete" onclick="return confirm('Are you sure that you want to delete?')">
                                             <input type="submit" class="btn btn-danger btn-xs" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; cursor: pointer; width:70px; margin-top:15px;" value="Delivery" name="update" onclick="return confirm('Are you sure that you want to Update the delivery status??')">
   
                                          </td>
                                             </div>    
                                          </form>
                                       </tr>
                                       <?php                                           
                                       }
                                       ?>
                                       </form>                                           
                                       </tbody>
                                 </table>
                                 <div class="pagination-container">
                                            <?php
                                            // Generate pagination links
                                            $pagination = '';
                                            if ($total_records > $records_per_page) {
                                                $total_pages = ceil($total_records / $records_per_page);
                                                $current_page = $page;

                                                $pagination .= '<ul class="pagination">';
                                                if ($current_page > 1) {
                                                    $pagination .= '<li><a href="?page='.($current_page - 1).'">&laquo;</a></li>';
                                                }
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    if ($i == $current_page) {
                                                        $pagination .= '<li><a href="?page='.$i.'" class="active">'.$i.'</a></li>';
                                                    } else {
                                                        $pagination .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
                                                    }
                                                }
                                                if ($current_page < $total_pages) {
                                                    $pagination .= '<li><a href="?page='.($current_page + 1).'">&raquo;</a></li>';
                                                }
                                                $pagination .= '</ul>';

                                                echo $pagination;
                                            }
                                            ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     <!-- end row -->
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
   </body>
</html>