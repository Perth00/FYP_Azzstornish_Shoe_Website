<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other page you want
echo "<script>
alert('Successfully logged out');
window.location.href = '../shoppers-gh-pages/index.php';
</script>";  
exit();
?>