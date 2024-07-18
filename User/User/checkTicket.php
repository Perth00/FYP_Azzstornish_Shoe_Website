<?php
session_start();

include "../object/database.php";
include "../object/database2.php";

include "../object/login.php";
include '../phpqrcode/qrlib.php';

   $Login = new Login("localhost", "user", "password", "finalproject");
   $Login2 = new Login2("localhost", "user", "password", "finalproject");

   $userID = isset($_SESSION["userID"]) ? $_SESSION["userID"] : "";
   $user = $Login->getUserDetail($userID);
   $amount = $Login2->getUserTotal($userID);

   
   $title=!empty($_POST["title"])?$_POST["title"]:"";

   $filter=!empty($_POST["filter"])?$_POST["filter"]:"";
   //$movieName = isset($_POST["movieName"]) ? $_POST["movieName"] : "";

   if (isset($_POST["ticket"])) 
   {
    $_SESSION["purchaseID"]=$_POST["purchaseID"];
    $_SESSION["purchaseTime"]=$_POST["purchaseTime"];
    $_SESSION["item"]=$_POST["item"];
    $_SESSION["price"]=$_POST["price"];
    $_SESSION["totalPrice"]=$_POST["totalPrice"];
    $_SESSION["qty"]=$_POST["qty"];
    $_SESSION["payMethod"]=$_POST["payMethod"];
    $_SESSION["userID"]=$_POST["userID"];
    $_SESSION["qr"]=$_POST["qr"];


    header("location:ticket.php");
   }
   if (isset($_POST["delete"])) {
    // Retrieve the purchaseID from the POST data
    $purchaseID = $_POST["purchaseID"];

    // Connect to your database (replace with your database connection code)
    $conn = mysqli_connect("localhost", "user", "password", "finalproject");

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Construct and execute the SQL DELETE statement
    $sql = "DELETE FROM purchase WHERE purchaseID = $purchaseID";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    // Close the database connection
    mysqli_close($conn);
}

// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "finalproject"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_pageCheck'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_pageCheck']) && is_numeric($_SESSION['current_pageCheck'])) {
    $page = $_SESSION['current_pageCheck'];
} else {
    $page = 1;
}
// Get the offset value for the SQL query
$offset = ($page - 1) * $records_per_page;


// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM purchase where userID='$userID'";
$result_total = mysqli_query($conn, $total_query);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                            <i class="fas fa-search" style="color:black;font-size:20px"> Search </i>
                                <form action="checkTicket.php" method="POST">
                                    <select name="filter"> <!--Filter the result-->
                                    <option value="purchaseID">Purchase ID </option>
                                        <option value="item">Item </option>
                                        <option value="price">price</option>
                                        <option value="totalPrice">totalPrice</option>
                                        <option value="qty">qty</option>

                                    </select>
                                <input type="text" placeholder="Search" name="title">
                                <button type="submit" class='btn btn-success btn-xs'
                                name="search" style="background-color:#1ed085">Search</button> 
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                     <div class="row column1">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">                              
                              </div>
                            <div class="full padding_infor_info">
                                <div class="row">
                                <div class="col-lg-12">
                                <div class="table_row">
                                <div class="full dis_flex center_text">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>purchaseID</th>
                                                <th>purchaseTime</th>
                                                <th>item</th>
                                                <th>price</th>
                                                <th>totalPrice</th>
                                                <th>qty</th>
                                                <th>payMethod</th>
                                                <th>userID</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                if (isset($_POST["search"])) 
                                                {                                                
                                                    // Filter the result based on the search criteria
                                                    if ($filter == "purchaseID") 
                                                    {
                                                        // Add appropriate conditions to the query based on the filter and key values
                                                        $sql = "SELECT * FROM purchase WHERE purchaseID = '$title' AND userID = '$userID' LIMIT $offset, $records_per_page";
                                                            if ($title == "") 
                                                            {
                                                                $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                            }
                                                    } 
                                                    else if ($filter == "price") 
                                                    {
                                                        $sql = "SELECT * FROM purchase WHERE item like '%$title%' AND userID = '$userID' LIMIT $offset, $records_per_page";
                                                        if ($title == "") 
                                                        {
                                                            $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                        }
                                                    }
                                                    else if ($filter == "price") 
                                                    {
                                                        $sql = "SELECT * FROM purchase WHERE price like '%$title%' AND userID = '$userID' LIMIT $offset, $records_per_page";
                                                        if ($title == "") 
                                                        {
                                                            $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                        }
                                                    }
                                                    else if ($filter == "totalPrice") 
                                                    {
                                                        $sql = "SELECT * FROM purchase WHERE totalPrice like '%$title%' AND userID = '$userID' LIMIT $offset, $records_per_page";
                                                        if ($title == "") 
                                                        {
                                                            $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                        }
                                                    }
                                                    else if ($filter == "qty") 
                                                    {
                                                        $sql = "SELECT * FROM purchase WHERE qty like '%$title%' AND userID = '$userID' LIMIT $offset, $records_per_page";
                                                        if ($title == "") 
                                                        {
                                                            $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                        }
                                                    }

                                                } 
                                                else 
                                                {
                                                    // If no search criteria provided, fetch all records for the given user
                                                    $sql = "SELECT * FROM purchase WHERE userID = '$userID' LIMIT $offset, $records_per_page";
                                                }
                                                    $result = mysqli_query($Login->conn, $sql);
                                                    $num = mysqli_num_rows($result); // count the number of rows
                                            ?>

                                            <?php
                                            while( $purchase = mysqli_fetch_assoc($result)) {

                                                $price=explode("\n", $purchase["price"]);
                                                $totalPrice=explode("\n", $purchase["totalPrice"]);
                                                $item=explode("\n", $purchase["item"]);
                                                $qty=explode("\n", $purchase["qty"]);

                                                ?>
                                                <tr>
                                                    
                                                    <td><?php echo $purchase["purchaseID"]?></td>
                                                    <td><?php echo $purchase["purchaseTime"]?></td>
                                                    <td><?php for($i=0;$i<count($price);$i++)
                                                    {
                                                        echo $item[$i]."<br>";
                                                    }?></td>                                                    
                                                    <td><?php for($i=0;$i<count($price);$i++)
                                                    {
                                                        echo "$".$price[$i]."<br>";
                                                    }?></td>
                                                    <td><?php for($i=0;$i<count($price);$i++)
                                                    {
                                                        echo "$".$totalPrice[$i]."<br>";
                                                    }?></td>                                                    
                                                    <td><?php for($i=0;$i<count($price);$i++)
                                                    {
                                                        echo $qty[$i]."<br>";
                                                    }?></td>                                                       
                                                    <td><?php echo $purchase["payMethod"]?></td>
                                                    <td><?php echo $purchase["userID"]?></td>
                                                    <td><?php echo $purchase["status"]?></td>

                                                    <form action="checkTicket.php" method="post">
                                                    <td>
                                                        <input type="hidden" name="purchaseID" value="<?php echo $purchase["purchaseID"]?>">
                                                        <input type="hidden" name="purchaseTime" value="<?php echo $purchase["purchaseTime"]?>">
                                                        <input type="hidden" name="item" value="<?php echo $purchase["item"]?>">
                                                        <input type="hidden" name="price" value="<?php echo $purchase["price"]?>">
                                                        <input type="hidden" name="totalPrice" value="<?php echo $purchase["totalPrice"]?>">
                                                        <input type="hidden" name="qty" value="<?php echo $purchase["qty"]?>">
                                                        <input type="hidden" name="payMethod" value="<?php echo $purchase["payMethod"]?>">
                                                        <input type="hidden" name="userID" value="<?php echo $purchase["userID"]?>">
                                                        <input type="hidden" name="qr" value="<?php echo $purchase["qr"]?>">

                                                        <div class="right_button">
                                                        <button class='btn btn-success btn-xs' name="ticket" onclick="showLoginPopup()">Check</button>
                                                        <?php 
                                                        
                                                        if (strcasecmp($purchase["status"], "Order Processed") === 0) 
                                                            {?>
                                                        <button class='btn btn-success btn-xs' name="delete" style="margin-top:15px;" onclick="return confirm('Are you sure that you want to save refund this item?')">Refund</button>
                                                        <?php
                                                         }?>
                                                        </div>
                                                    </td>
                                                </form>
                                                </tr>
                                                <?php
                                            }
                                            ?>
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
                    <div class="col-md-6">
                        <div class="full white_shd">
                            <div class="full graph_head">
                                <div class="heading1 margin_0">
                                    <h2>Total Amount</h2>
                                </div>
                            </div>
                            <div class="full padding_infor_info">
                                <div class="price_table">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$<?php echo number_format($amount,2,".")?></td>
                                            </tr>
                                            <tr>
                                                <th>Tax (10%)</th>
                                                <td>$<?php echo number_format($amount * 0.10, 2, "."); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$<?php echo is_numeric($amount) ? number_format($amount * 1.10, 2, ".") : "Invalid amount"; ?></td>
                                            </tr>
                                            </tbody>                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

</body>
</html>
