<?php
session_start();
include "../object/database.php";
include "../object/login.php";



if(isset($_GET['percentage'])){
    // Update session variable

    $percentage=15;
    $percentage=$percentage/100;
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
} else {
    echo "Error: Percentage not received";
}
?>
