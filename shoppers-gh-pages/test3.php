<?php
session_start();
include "../object/database.php";
include "../object/login.php";

$Login = new Login("localhost", "user", "password", "finalproject");
function generateRandomString($length = 4) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}


    $percentage=5;
    $percentage=$percentage/100;
    $userID=empty($_SESSION["userID"])?"":$_SESSION["userID"];
    $available="available";
    $currentDate = date("Y-m-d"); // Current date in the format YYYY-MM-DD

    // Add one month to the current date
    $oneMonthLater = date("Y-m-d", strtotime("+1 month", strtotime($currentDate)));
    $offer = generateRandomString(6);
    $result = $Login->setVoucher($offer, $percentage, $userID, $available, $oneMonthLater);

    if ($result) {
        echo "Success";
    } else {
        echo "Error updating database";
    }
    
?>
