<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php 
  include "../object/database.php";
  include "../object/sendPic.php";
  include "../object/verification.php";
  include "../object/login.php";

  $Login = new Login("localhost", "user", "password", "finalproject");
  $register = new register("localhost", "user", "password", "finalproject");
  $verification= new Verification();
  $userErr="";
  $emailErr="";
  $posswordErr1="";
  $posswordErr2="";

  if(isset($_POST["submit"]))
  {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password1 = isset($_POST["password1"]) ? $_POST["password1"] : "";
    $password2 = isset($_POST["password2"]) ? $_POST["password2"] : "";
    $image="images.png";
    $userErr=$verification->ErrorName($name);
    $posswordErr1=$verification->Errorpw($password1);
    $posswordErr2=$verification->Errorpw($password2);
    $emailErr=$verification->Errorm($email);


    if ($password1 == $password2) 
    {
      if(empty($userErr) AND empty($posswordErr1) AND empty($posswordErr2) AND empty($emailErr))
      {  
          $error = $register->register($name, $password1, $email, $image);
  
          if (!empty($error)) {
              echo "<script>
                  alert('$error');
                  window.location.href = 'register.php';
              </script>";
          }
          else
          {
            echo "<script>
            alert('successfully registered the account');
            window.location.href = '../shoppers-gh-pages/index.php';
        </script>";
          }
    }
  } 
  else {
      echo "<script>
          alert('Please ensure your passwords are entered correctly');
          window.location.href = 'register.php';
      </script>";
  }
  
  }
  ?>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registration or Sign Up form in HTML CSS | CodingLab </title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../User/images/logo/logo_white  - Copy.jpeg" type="image/png" />
    <style>

/************animation*****/

.circles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
 
}
.circles li {
    position: absolute;
   z-index:9;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
}
.circles li:nth-child(1) {
    left: 25%;
    width: 40px;
    height: 40px;
    animation-delay: 0s;
}
.circles li:nth-child(2) {
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}
.circles li:nth-child(3) {
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}
.circles li:nth-child(4) {
    left: 40%;
    width: 35px;
    height: 35px;
    animation-delay: 0s;
    animation-duration: 18s;
}
.circles li:nth-child(5) {
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}
.circles li:nth-child(6) {
    left: 75%;
    width: 30px;
    height: 30px;
    animation-delay: 3s;
}
.circles li:nth-child(7) {
    left: 35%;
    width: 35px;
    height: 35px;
    animation-delay: 7s;
}
.circles li:nth-child(8) {
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}
.circles li:nth-child(9) {
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}
.circles li:nth-child(10) {
    left: 85%;
    width: 35px;
    height: 35px;
    animation-delay: 0s;
    animation-duration: 11s;
}

@keyframes animate {
  0% {
    transform: translateY(0) rotate(0deg);
    opacity: 1;
    border-radius: 0;
  }

  100% {
    transform: translateY(-1000px) rotate(720deg);
    opacity: 0;
    border-radius: 50%;
  }

}

body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-position: center;
    background-size: cover;
    background-image: url(https://images.unsplash.com/photo-1618005198920-f0cb6201c115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80);
      background-color: #ececec;
}

input:hover {
        transform: scale(1.1); 
    }
    .buttons-container button:hover {
        background-color: #0056b3;
         
    }
</style>
</head>
<body>
  <!--dust particel-->
<ul class="circles"> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> 
</ul>
  <div class="wrapper">
    <h2>Registration</h2>
    <form action="register.php" method="POST">
    <?php
        if ($userErr == "") {
          // If the error is empty, this row does not appear

        } 
        else {
          // If the error is not empty, display the error message
      ?>
          <span style="color:red;"><b><?php echo $userErr; ?></b></span><br>
      <?php
        }
      ?>      
      <div class="input-box">
        <input type="text" placeholder="Enter your name" name="name" >
      </div>
      <?php
        if ($emailErr == "") {
          // If the error is empty, this row does not appear

        } else {
          // If the error is not empty, display the error message
      ?>
          <span style="color:red;"><b><?php echo $emailErr; ?></b></span><br>
      <?php
        }
      ?>      
      <div class="input-box">
        <input type="text" placeholder="Enter your email" name="email" >
      </div>
      <?php
        if ($posswordErr1 == "") {
          // If the error is empty, this row does not appear

        } else {
          // If the error is not empty, display the error message
      ?>
          <span style="color:red;"><b><?php echo $posswordErr1; ?></b></span><br>
      <?php
        }
      ?>      
      <div class="input-box">
        <input type="password" placeholder="Create password" name="password1" >
      </div>
      <?php
        if ($posswordErr2 == "") {
          // If the error is empty, this row does not appear

        } else {
          // If the error is not empty, display the error message
      ?>
          <span style="color:red;"><b><?php echo $posswordErr2; ?></b></span><br>
      <?php
        }
      ?>
      <div class="input-box">
        <input type="password" placeholder="Confirm password" name="password2" >
      </div>
    
      <div class="policy">
        <input type="checkbox" required>
        <h3>I accept all terms & condition</h3>
      </div>
      
      <div class="input-box button">
        <input type="Submit" name="submit" value="Register Now">
      </div>

      <div class="text">
        <h3>Already have an account? <a href="../shoppers-gh-pages/index.php">Login now</a></h3>
      </div>
    </form>
  </div>

</body>
</html>
