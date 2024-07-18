<?php 


class Login {
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

    public function UploadProduct($name,$image,$cID) 
    {
        $sql = "UPDATE category 
        SET cName = '$name', Image = '$image'
        WHERE cID = $cID";
        $result = $this->conn->query($sql);

        header("location: admin_show_category.php");
    }

    public function UploadStatusAvailable($code) 
    {
        // SQL query with a placeholder
        $sql = "UPDATE discount SET available='unavailable' WHERE offer = ?";
    
        // Prepare the statement
        $stmt = mysqli_prepare($this->conn, $sql);
    
        if (!$stmt) {
            // Handle error if preparation fails
            die("Error: " . mysqli_error($this->conn));
        }
    
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $code);
    
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
    
        if (!$result) {
            // Handle error if execution fails
            die("Error: " . mysqli_error($this->conn));
        }
    
        // Close the statement
        mysqli_stmt_close($stmt);
    }
    


    public function setVoucher($offer, $percentage, $userID, $available, $date) 
    {
        // Prepare the SQL statement
        $sql = "INSERT INTO discount (offer, percentage, userID, available, date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
    
        // Bind the parameters and execute the statement
        $stmt->bind_param("sssss", $offer, $percentage, $userID, $available, $date);
        $result = $stmt->execute();
    
        // Check for success
        if ($result) {
            return true;
        } else {
            // If there's an error, you can log or handle it appropriately
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    
    public function showvoucher($userID)
    {
        // Use parameterized query to prevent SQL injection
        $check_query = "SELECT * FROM discount WHERE userID = ? AND date >= CURRENT_DATE AND available= 'Available'";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($check_query);
    
        if (!$stmt) {
            echo "Error preparing statement: " . $this->conn->error;
            return [];
        }
    
        // Bind the parameter
        $stmt->bind_param("s", $userID);
    
        // Execute the statement
        $result = $stmt->execute();
    
        if (!$result) {
            echo "Error executing query: " . $stmt->error;
            return [];
        }
    
        // Get the result set
        $ra = [];
    
        $result_set = $stmt->get_result();
    
        // Fetch the rows
        while ($row = $result_set->fetch_assoc()) {
            $ra[] = $row;
        }
    
        // Close the statement
        $stmt->close();
    
        return $ra;
    }
    
    

    public function showCategory()
    {
        $check_query = "SELECT * FROM category ORDER BY cID ASC";
        $result = mysqli_query($this->conn, $check_query);
    
        $category = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $category[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $category;
    }

    public function showTopProduct()
    {
        $check_query = "SELECT * FROM product where status='Top' ORDER BY pID ASC LIMIT 8";
        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $product;
    }

    public function showProduct()
    {
        $check_query = "SELECT * FROM product ORDER BY pID ASC ";
        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $product;
    }

    public function showDiscount($code)
    {
        $check_query = "SELECT * FROM discount WHERE offer = '$code' ";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function showDetailProduct($series,$color,$pName,$category)
    {
        $check_query = "SELECT * FROM product WHERE color = '$color' AND series = '$series' and category='$category' and pName='$pName' ORDER BY pID ASC";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
    public function showDetailImageProduct($series,$category,$pName)
    {
        $check_query = "SELECT * 
        FROM product 
        WHERE series = '$series' AND category = '$category' and pName='$pName'
        GROUP BY color 
        ORDER BY pID ASC; ";
        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $product;
    }

    public function showDetailColorProduct($series,$category,$pName)
    {
        $check_query = "SELECT pName, color, series, category, size FROM product WHERE series = '$series' and category = '$category' and pName='$pName' GROUP BY pName,color ORDER BY pID ASC";
        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $product;
    }
    
    
    public function showSize($series,$color,$pName,$category)
    {
        $check_query = "SELECT * FROM product WHERE series = '$series' and color='$color' and pName='$pName' and category='$category'Group by size ORDER BY pID ASC";
        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $product;
    }

    public function getUser($userID)
    {
        $check_query = "SELECT * FROM user WHERE userID='$userID'";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
  
    public function getUserEmail($Email)
    {
        $check_query = "SELECT * FROM user WHERE Email='$Email'";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }


    public function getUserTotal($userID)
   {
       $check_query = "SELECT SUM(totalPrice) FROM purchase WHERE userID = '$userID'";
       $result = mysqli_query($this->conn, $check_query);
   
       if ($result && mysqli_num_rows($result) > 0) {
           $row = mysqli_fetch_assoc($result);
           return $row['totalPrice'];
       } else {
           echo "No amount to show for userID: " . $userID;
           return 0; // Return a default value if no amount is found
       }
   }

    public function showFilterProduct($women, $men, $children, $red, $green, $blue, $purple, $white, $black,$yellow)
    {
        // Start the base query
        $base_query = "SELECT * FROM product";
    
        // Initialize an empty array to store the conditions
        $conditions = [];
    
        // Check if the user selected any category
        $categories = [];
        if ($women) $categories[] = "'women'";
        if ($men) $categories[] = "'men'";
        if ($children) $categories[] = "'children'";
    
        // Check if the user selected any color
        $colors = [];
        if ($red) $colors[] = "'red'";
        if ($green) $colors[] = "'green'";
        if ($blue) $colors[] = "'blue'";
        if ($purple) $colors[] = "'purple'";
        if ($white) $colors[] = "'white'";
        if ($black) $colors[] = "'black'";
        if ($yellow) $colors[] = "'yellow'";

        // Construct the category and color conditions
        $category_condition = "";
        $color_condition = "";
    
        if (!empty($categories)) {
            $category_condition = "category IN (" . implode(", ", $categories) . ")";
            $conditions[] = $category_condition;
        }
    
        if (!empty($colors)) {
            $color_condition = "color IN (" . implode(", ", $colors) . ")";
            $conditions[] = $color_condition;
        }
    
        // Combine the conditions with "OR" to allow the user to select either category or color
        $final_condition = implode(" OR ", $conditions);
    
        // Add the combined condition to the base query
        if (!empty($final_condition)) {
            $base_query .= " WHERE " . $final_condition;
        }
    
        // Optionally, you can order the results
        $base_query .= " ORDER BY pID ASC";
    
        $result = mysqli_query($this->conn, $base_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row;
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
    
        return $product;
    }
    
    
    
    public function showFilterSearchProduct($women, $men, $children, $red, $green, $blue, $purple, $white, $black, $title,$yellow)
    {
        // Start the base query
        $base_query = "SELECT * FROM product WHERE ";
        
        // Initialize an empty array to store the conditions
        $conditions = [];
    
        // Add a condition for the title
        $conditions[] = "pName LIKE ?";
        
        // Check if the user selected any category
        $categories = [];
        if ($women) $categories[] = "'women'";
        if ($men) $categories[] = "'men'";
        if ($children) $categories[] = "'children'";
        
        // Check if the user selected any color
        $colors = [];
        if ($red) $colors[] = "'red'";
        if ($green) $colors[] = "'green'";
        if ($blue) $colors[] = "'blue'";
        if ($purple) $colors[] = "'purple'";
        if ($white) $colors[] = "'white'";
        if ($black) $colors[] = "'black'";
        if ($yellow) $colors[] = "'yellow'";

        // Construct the category and color conditions
        $category_condition = "";
        $color_condition = "";
        
        if (!empty($categories)) {
            $category_condition = "category IN (" . implode(", ", $categories) . ")";
            $conditions[] = $category_condition;
        }
        
        if (!empty($colors)) {
            $color_condition = "color IN (" . implode(", ", $colors) . ")";
            $conditions[] = $color_condition;
        }
        
        // Combine the conditions with "AND" to allow the user to select either category or color
        $final_condition = implode(" AND ", $conditions);
        
        // Add the combined condition to the base query
        $final_query = $base_query . $final_condition;
        
        // Optionally, you can order the results
        $final_query .= " ORDER BY pID ASC";
        
        // Use prepared statements to safely include user input
        $stmt = mysqli_prepare($this->conn, $final_query);
        if ($stmt) {
            $titleParam = "%" . $title . "%";
            mysqli_stmt_bind_param($stmt, "s", $titleParam);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            $product = [];
        
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product[] = $row;
                }
            } else {
                echo "Error executing query: " . mysqli_error($this->conn);
            }
        
            return $product;
        } else {
            echo "Error preparing query: " . mysqli_error($this->conn);
        }
    }
    
    public function showDetailQtyProduct($series,$color,$size,$pName)
    {
        $check_query = "SELECT * FROM product WHERE color = '$color' AND series = '$series' and size='$size' and pName='$pName' ORDER BY pID ASC";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }


    public function showSearchProduct($title)
    {
        $check_query = "SELECT * FROM product where pName like '%$title%' or series like '$title' ORDER BY pID ASC ";
        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
        return $product;
    }

    public function showCategoryProduct($title)
    {
        $check_query = "SELECT * FROM product where category = '$title' ORDER BY pID ASC ";
        $result = mysqli_query($this->conn, $check_query);
    
        $row=mysqli_num_rows($result);
        $product = [];

        if($row<1)
        {

        }
        else
        {
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product[] = $row; 
                }
            } else {
                echo "Error executing query: " . mysqli_error($this->conn);
            }
        }
    

        return $product;
    }

    public function getCategory($cID)
    {
        $check_query = "SELECT * FROM category WHERE cID='$cID'";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
    
    public function checkUserAdmin($Name, $Password, $Email,$Image) 
    {
        $errorMsg = "";
        $sql = "SELECT * FROM user WHERE LOWER(Email) = LOWER('$Email')";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<script>
            alert('Email is repeated');
            window.location.href = 'addUser.php';
            </script>";         } else {
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(Name, Password, Email, Image) 
                    VALUES ('$Name', '$hashedPassword','$Email',  '$Image')";
            $errorMsg="";
            $result = $this->conn->query($sql);
            session_start();
            $_SESSION["Email"] = $Email;
            echo "<script>
            alert('The account is successfully created!!!!');
            window.location.href = 'UserInfo.php';
            </script>";         }
        mysqli_close($this->conn);
    }
    public function isEmailExistsAdmin($userID,$Name,$Image,$Email) 
    {
        $check_query = "SELECT * FROM user WHERE Email ='$Email'";
        $result = mysqli_query($this->conn, $check_query);
        $check_result = mysqli_num_rows($result);
    
        if ($check_result == 0) {
            $sql = "UPDATE user SET Name = '$Name', Email = '$Email', Image='$Image' WHERE userID = '$userID' ";

            if (mysqli_query($this->conn, $sql)) {
                echo "<script>
                alert('Change successfully!!!');
                window.location.href = 'UserInfo.php';
                </script>"; 
            } else {
                echo "Error updating data: " . mysqli_error($this->conn);
            }
        } else {
            echo "<script>
            alert('Email is repeated');
            window.location.href = 'UserInfo.php';
            </script>"; 
        }
    }

    public function updateuserdetailsAdmin($userID,$Name,$Image,$Email) 
    {
        $check_query = "SELECT * FROM user WHERE userID ='$userID'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) 
        {
            $sql = "UPDATE user SET Name = '$Name', Image='$Image' WHERE userID = '$userID' ";
            if (mysqli_query($this->conn, $sql)) 
            {
                echo "<script>
                alert('Change successfully!!!');
                window.location.href = 'UserInfo.php';
                </script>"; 
            } else {
                echo "Error updating data: " . mysqli_error($this->conn);
            }
        } else {
            die("Unable to save changes.");
        }
    }

    public function updateuserdetails($userID,$Name,$Image,$Email) 
    {
        $check_query = "SELECT * FROM user WHERE userID ='$userID'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) 
        {
            $sql = "UPDATE user SET Name = '$Name', Image='$Image' WHERE userID = '$userID' ";
            if (mysqli_query($this->conn, $sql)) 
            {
                $sql="SELECT * From user WHERE Email='$Email'";
                $result=mysqli_query($this->conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $username=$row["Name"];
                $userID=$row["userID"];
                $image=$row["Image"];

                $_SESSION['email'] = $Email;
                $_SESSION['username'] = $username;
                $_SESSION['image'] =$image;

                echo "Changes saved successfully.";
                header("location:profile.php");
            } else {
                echo "Error updating data: " . mysqli_error($this->conn);
            }
        } else {
            die("Unable to save changes.");
        }
    }
    public function getUserDetail($userID)
    {
        $check_query = "SELECT * FROM user WHERE userID='$userID'";
        $result = mysqli_query($this->conn, $check_query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            echo "No user found with ID: " . $userID;
            return null;
        }

    }

    public function isEmailExists($userID,$Name,$Image,$Email) 
    {
        $check_query = "SELECT * FROM user WHERE Email ='$Email'";
        $result = mysqli_query($this->conn, $check_query);
        $check_result = mysqli_num_rows($result);
    
        if ($check_result == 0) {
            $sql = "UPDATE user SET Name = '$Name', Email = '$Email',  Image='$Image' WHERE userID = '$userID' ";

            if (mysqli_query($this->conn, $sql)) {
                $sql="SELECT * From user WHERE Email='$Email'";
                $result=mysqli_query($this->conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $username=$row["Name"];
                $userID=$row["userID"];
                $image=$row["Image"];

                $_SESSION['email'] = $Email;
                $_SESSION['username'] = $username;
                $_SESSION['image'] =$image;

                echo "Changes saved successfully.";
                header("location: profile.php");
            } else {
                echo "Error updating data: " . mysqli_error($this->conn);
            }
        } else {
            $message = "Email is repeated!!";
        }
        return $message;
    }
    public function getProductDetail($pID)
    {
        $check_query = "SELECT * FROM product WHERE pID='$pID'";
        $result = mysqli_query($this->conn, $check_query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            echo "No product found with ID: " . $pID;
            return null;
        }
    }
    public function addProduct($pName,$series,$image,$size,$price,$details,$qty,$status,$color,$category,$video) 
    {
        $sql = "INSERT INTO product (pName, series, image, size, price, details, qty, status, color,category, video) 
                VALUES ('$pName','$series','$image','$size','$price','$details','$qty','$status','$color','$category','$video')";
        $result = $this->conn->query($sql);
        echo "<script>
        alert('Successfully Added');
        window.location.href = 'admin_show_product.php';
        </script>";  
    }

    public function updateProduct($pID,$pName,$series,$image,$size,$price,$details,$qty,$status,$color,$category,$video) 
    {
        $check_query = "SELECT * FROM product WHERE pID ='$pID'";
        $result = mysqli_query($this->conn, $check_query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            // Movie exists, perform the update operation
            $sql = "UPDATE product
            SET pName = '$pName', 
                price = '$price', 
                image = '$image',
                series = '$series',
                size = '$size',
                details = '$details',
                qty = '$qty',
                status = '$status',
                color = '$color',
                category = '$category',
                video = '$video'
            WHERE pID = '$pID'";
            
            if (mysqli_query($this->conn, $sql)) {
                // Update successful
                header("location: admin_show_product.php");
            } else {
                // Error executing update query
                echo "Error updating product: " . mysqli_error($this->conn);
            }
        } else {
            // Movie does not exist
            echo "Product not found.";
        }
    }

    public function UploadPurchase($purchaseTime, $item, $price, $totalPrice, $qty, $qr, $payMethod, $userID) 
    {
        $sql = "INSERT INTO purchase (purchaseTime, item, price, totalPrice, qty, qr, payMethod, userID,status) 
                VALUES ('$purchaseTime', '$item', '$price', '$totalPrice', '$qty', '$qr', '$payMethod', $userID, 'Order Processed')";
        $result = $this->conn->query($sql);
        if ($result) {
            $sql="SELECT * From purchase WHERE purchaseTime='$purchaseTime' AND item='$item' AND price='$price' AND totalPrice='$totalPrice'
            AND qty='$qty' AND qr='$qr' AND payMethod='$payMethod' AND userID='$userID'";
            $result=mysqli_query($this->conn,$sql);
            $row=mysqli_fetch_assoc($result);
            return $row;
        }

    }
    
    public function addDiscount($offer,$percentage, $userID,$available,$date) 
    {
        $sql = "INSERT INTO discount (offer,percentage,userID,available,date) 
                VALUES ('$offer','$percentage','$userID','$available','$date')";
        $result = $this->conn->query($sql);
        echo "<script>
        alert('Successfully Added');
        window.location.href = 'admin_show_discount.php';
        </script>";  
    }

    public function deleteProduct($pID)
    {
        $sql = "DELETE FROM product WHERE pID = '$pID'";
        
        if (mysqli_query($this->conn, $sql)) {
        } else {
            echo "Error deleting row: " . mysqli_error($this->conn);
        }
    }
    public function deleteDiscount($Oid)
    {
        $sql = "DELETE FROM discount WHERE Oid = '$Oid'";
        
        if (mysqli_query($this->conn, $sql)) {
        } else {
            echo "Error deleting row: " . mysqli_error($this->conn);
        }
    }

    public function deleteUser($userID)
    {
        $sql = "DELETE FROM user WHERE userID = '$userID'";
        
        if (mysqli_query($this->conn, $sql)) {
        } else {
            echo "Error deleting row: " . mysqli_error($this->conn);
        }
    }
    
    public function deletePurchase($purchaseID)
    {
        $sql = "DELETE FROM purchase WHERE purchaseID = '$purchaseID'";
        
        if (mysqli_query($this->conn, $sql)) {
        } else {
            echo "Error deleting row: " . mysqli_error($this->conn);
        }
    }
    public function getDiscount($Oid)
    {
        $check_query = "SELECT * FROM discount WHERE Oid='$Oid'";
        $result = mysqli_query($this->conn, $check_query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            echo "No Discount found with ID: " . $Oid;
            return null;
        }
    }

    public function updateDiscount($Oid,$offer, $percentage, $userID,$available,$date) 
    {
        $check_query = "SELECT * FROM discount WHERE Oid ='$Oid'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) 
        {
            $sql = "UPDATE discount SET Oid = '$Oid', offer = '$offer', percentage = '$percentage', userID = '$userID', available = '$available', date = '$date' WHERE Oid = '$Oid' ";
            if (mysqli_query($this->conn, $sql)) 
            {
                echo "Changes saved successfully.";
                header("location:admin_show_discount.php");
            } else {
                echo "Error updating data: " . mysqli_error($this->conn);
            }
        } else {
            die("Unable to save changes.");
        }
        
    }
    public function showStatisticProduct()
{
    $check_query = "SELECT series, SUM(pID) AS pID1
    FROM product
    GROUP BY series
    HAVING pID1 > 0";

    $result = mysqli_query($this->conn, $check_query);
    
    $product = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product[] = $row; 
        }
    } else {
        echo "Error executing query: " . mysqli_error($this->conn);
    }
    
    return $product;
}

public function showStatisticProductCategoryWomen()
{
    $check_query = "SELECT series,category, SUM(qty) AS c
    FROM product
    where category='women'
    GROUP BY series,category
    ORDER BY series ASC
    ";

    $result = mysqli_query($this->conn, $check_query);
    
    $product = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product[] = $row; 
        }
    } else {
        echo "Error executing query: " . mysqli_error($this->conn);
    }
    return $product;
}

public function showStatisticProductCategoryMen()
{
    $check_query = "SELECT series,category, SUM(qty) AS c
    FROM product
    where category='Men'
    GROUP BY series,category
    ORDER BY series ASC
    ";

    $result = mysqli_query($this->conn, $check_query);
    
    $product = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product[] = $row; 
        }
    } else {
        echo "Error executing query: " . mysqli_error($this->conn);
    }
    return $product;
}

public function showStatisticProductCategoryChildren()
{
    $check_query = "SELECT series,category, SUM(qty) AS c
    FROM product
    where category='Children'
    GROUP BY series,category
    ORDER BY series ASC
    ";

    $result = mysqli_query($this->conn, $check_query);
    
    $product = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product[] = $row; 
        }
    } else {
        echo "Error executing query: " . mysqli_error($this->conn);
    }
    return $product;
}

public function showStatisticProductQty()
{
    $check_query = "SELECT series, SUM(qty) AS qty1
    FROM product
    GROUP BY series
    HAVING qty1 > 0
    ORDER BY series ASC
    ";

    $result = mysqli_query($this->conn, $check_query);
    
    $product = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product[] = $row; 
        }
    } else {
        echo "Error executing query: " . mysqli_error($this->conn);
    }
    
    return $product;
}
    public function showStatisticSeries()
    {
        $check_query = "SELECT series FROM product GROUP by series";

        $result = mysqli_query($this->conn, $check_query);
    
        $product = [];
    
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row; 
            }
        } else {
            echo "Error executing query: " . mysqli_error($this->conn);
        }
    
        return $product;
    }



    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }

    
    
}


class email{
    //generate a random verify
    function sendUpdatedUserDetailsEmail($recipientEmail)
    {
        $subject = "Updated User Details Notification";
        
        $message = "Dear User,\n\n";
        $message .= "We wanted to inform you that some of your details have been updated in our system. Please review the updated information below:\n\n";
        $message .= "If you did not make any changes to your details or if you believe this is an error, please contact our customer support team immediately.\n\n";
        $message .= "Best regards,\nAzzstornish";
        $headers = "From: phptesting00@gmail.com";
        // Send the email
        mail($recipientEmail, $subject, $message, $headers);
    }
    
}


?>