<?php 


class Login2 {
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }
    
    public function getProductQty($productId) {
        $sql = "SELECT * FROM product WHERE pID = '$productId'";
        $result = mysqli_query($this->conn, $sql);
        
        if (!$result) {
            // Handle the database error (e.g., log it)
            die("Database error: " . mysqli_error($this->conn));
        }
        
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            // Handle the case where the product with the given ID was not found
            return null;
        }
    }
    
    public function getProductQty2($productId) {
        $sql = "SELECT qty FROM product WHERE pID = '$productId'";
        $result = mysqli_query($this->conn, $sql);
        
        if (!$result) {
            // Handle the database error (e.g., log it)
            die("Database error: " . mysqli_error($this->conn));
        }
        
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['qty']; // Return the 'qty' column value
        } else {
            // Handle the case where the product with the given ID was not found
            return null;
        }
    }
    
    
    public function deleteProductQty($pId, $qty) {
        // Get the current quantity from the database
        $currentQty = $this->getProductQty($pId);
    
        if (!empty($currentQty) && $currentQty["qty"] >= $qty) {
            // Update the product quantity
            $sql = "UPDATE product
                    SET qty = qty - $qty
                    WHERE pID = '$pId';";
            $result = $this->conn->query($sql);
            return true;
        } else {
            // Product has been sold out or there's an issue with the database query
            echo "<script>
                alert('We are so sorry the product has been sold off, please choose another product.');
                window.location.href = 'index.php';
            </script>";
            return false;
        }
    }
    
    public function AdminLogin($email, $password)  // this is for admin login 
    {
        $email=strtolower($email); //lowercacse for the email
        $check_query = "SELECT * FROM admin WHERE email='$email' and password='$password'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking the output and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) 
        { //if the number is one that mean the account is existed
                session_start();
                $errorP=" "; //clear the reminder to be null;
                header("location: ../Admin/UserInfo.php"); 
                exit();
            } 
         else 
         {//the account is not existed or invalid password or ID
            $errorP="Username or password is incorrect";
        }
        mysqli_close($this->conn);
        return $errorP;
    } 
    public function showReceipt($purchaseID ) {
        $sql = "SELECT * FROM purchase WHERE purchaseID  = '$purchaseID'";
        $result = mysqli_query($this->conn, $sql);
        
        if (!$result) {
            // Handle the database error (e.g., log it)
            die("Database error: " . mysqli_error($this->conn));
        }
        
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            // Handle the case where the product with the given ID was not found
            return null;
        }
    }

    public function getUserTotal($userID)
    {
        $check_query = "SELECT SUM(totalPrice) AS totalAmount FROM purchase  WHERE userID = '$userID'";
        $result = mysqli_query($this->conn, $check_query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalAmount'];
        } else {
            echo "No amount to show for userID: " . $userID;
            return 0; // Return a default value if no amount is found
        }
    }

    public function getQr($purchaseID)
    {
        $check_query = "SELECT * FROM purchase WHERE purchaseID = '$purchaseID'";
        $result = mysqli_query($this->conn, $check_query);
        $row = mysqli_fetch_assoc($result);

        return $row;
    }

    public function getDeliveryStatus($purchaseID) {
        $sql = "SELECT * FROM purchase WHERE purchaseID = '$purchaseID'";
        $result = mysqli_query($this->conn, $sql);
        
        if (!$result) {
            // Handle the database error (e.g., log it)
            die("Database error: " . mysqli_error($this->conn));
        }
        
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            // Handle the case where the product with the given ID was not found
            return null;
        }
    }


    public function UpdatedelivertStatus($purchaseID,$status) 
    {
        $sql = "UPDATE purchase 
        SET status='$status'
        WHERE purchaseID = $purchaseID";
        $result = $this->conn->query($sql);
    }

}
class email2{
    //generate a random verify
    function sendPurchaseConfirmationEmail($recipientEmail)
    {
        $subject = "Purchase Confirmation";
        
        $message = "Dear Customer,\n\n";
        $message .= "Thank you for your purchase. Your order has been successfully processed.\n";
        $message .= "To check the status of your purchased items, please check your account's status information for further details.\n";
        $message .= "If you have any questions or need assistance, feel free to contact our customer support team.\n\n";
        $message .= "Thank you for shopping with us!\n";
        $message .= "Best regards,\nAZZSTORNISH";
        
        $headers = "From: phptesting00@gmail.com";
        
        // Additional headers to set content type as plain text
        $headers .= "\r\nContent-type: text/plain; charset=UTF-8";
        
        // Send the email
        mail($recipientEmail, $subject, $message, $headers);
        
    }
    

    function sendDeliveryStatusEmail($recipientEmail, $status) {
        // Email subject
        $subject = "Delivery Status Update - $status";
        $message = "Dear [$recipientEmail],\n\n";

        // Email message based on the status
        switch ($status) {
            case "Order Processed":
                $message .= "We are pleased to inform you that your order has been successfully processed. Your items are now being prepared for shipment.\n";
                break;
            case "Order Shipped":
                $message .= "Great news! Your order has been shipped and is on its way to your specified delivery address. It should arrive shortly.\n";
                break;
            case "Order En Route":
                $message .= "Your order is currently en route and on its way to your location. Please expect the delivery to be completed soon.\n";
                break;
            case "Order Arrived":
                $message .= "Congratulations! Your order has successfully arrived at its destination. You can expect the delivery to be completed within the next 24 hours.\n";
                break;
            default:
                $message .= "We have an update regarding your order. Please check your account for the latest delivery status information.\n";
                break;
        }
    
        $message .= "If you have any specific delivery instructions or any questions regarding your order, please don't hesitate to reach out to our customer support team. We're here to assist.\n\n";
        $message .= "Best regards,\nAZZSTORNISH";
    
        // Additional headers to set content type as plain text
        $headers = "From: phptesting00@gmail.com";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
    
        // Send the email
        if (mail($recipientEmail, $subject, $message, $headers)) {
            return true; // Email sent successfully
        } else {
            return false; // Email delivery failed
        }
    }


}
?>