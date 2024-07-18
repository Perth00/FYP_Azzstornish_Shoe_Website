<?php 

session_start();
session_destroy();
echo "<script>
alert('Logout the account successful!!!');
window.location.href = '../shoppers-gh-pages/index.php';
</script>"; // Redirect to the desired page after deletion
?>