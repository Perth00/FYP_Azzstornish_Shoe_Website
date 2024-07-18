<?php 
class register{
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

    public function register($Name, $Password, $Email,$image)  { //function for registering
        $email=strtolower($Email); //lowercacse for the email
        $errorP="";
        $check_query = "SELECT * FROM user WHERE Email='$email'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 0) {
            $password = password_hash($Password, PASSWORD_DEFAULT); // secure the password for preventing hacker
            $sql = "INSERT INTO user(Name, Password, Email, Image) 
                    VALUES ('$Name', '$password', '$email','$image')";
            $errorP=""; //clear the reminder to be null;
            mysqli_query($this->conn,$sql);//connect to database for checking the output
            session_start();
        } 
        else {
            $errorP="Email is repeated";
        }
        mysqli_close($this->conn);
        return $errorP;
    }

    public function login($email, $password) 
    {
        $email=strtolower($email); //lowercacse for the email
        $check_query = "SELECT * FROM user WHERE Email='$email'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking the output and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) { //if the number is one that mean the account is existed
            $user = mysqli_fetch_assoc($result);//store the account as a array
            if (password_verify($password, $user['Password'])) {  //verify the password matches a hash.
                $login1 = "UPDATE user SET TimeOfLogin = TimeOfLogin + 1 WHERE Email = '$email'";
                mysqli_query($this->conn,$login1);

                $sql="SELECT * From user WHERE Email='$email'";
                $result=mysqli_query($this->conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $username=$row["Name"];
                $userID=$row["userID"];
                $image=$row["Image"];
                $TimeOfLogin=$row["TimeOfLogin"];
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['userID'] =$userID;
                $_SESSION['image'] =$image;
                $_SESSION['TimeOfLogin'] = $row["TimeOfLogin"];

                echo "<script>
                alert('Successfully logged in');
                window.location.href = 'index.php';
                </script>";            
            } 
            else 
            {
                echo "<script>
                alert('Username or password is incorrect');
                window.location.href = 'login.php';
                </script>"; 
            }
        } else {//the account is not existed or invalid password or ID
            echo "<script>
            alert('Username or password is incorrect');
            window.location.href = 'login.php';
            </script>";         }
        mysqli_close($this->conn);
    }
}
?>