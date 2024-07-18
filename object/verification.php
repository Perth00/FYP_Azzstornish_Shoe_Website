<?php 

class Verification {

    
        
    public function ErrorName($name) {
        $error = $name;
        if (!empty($error)) {
            if (!preg_match("/^[A-Za-z0-9.,\- ]+$/", $name)) {
                $error = "Only alphabets are allowed!";
            } else {
                $error = ""; // If entered correctly, clear the value
            }
        } else {
            $error = "Fill in the field.";
        }
        return $error;
    }

    

    public function Errorm($email) {
        $error = $email;
        if (empty($error)) {
            $error= "Email is required!!";
        } else if (!filter_var($error, FILTER_VALIDATE_EMAIL)) {
            return "Wrong email format!";
        } else {
            $error = "";
        }
        return $error;
    }

       
    public function Errorpw($password) {
        $error = $password;
        if (empty($error)) {
            return "Fill in your password.";
        } else {
            if (strlen($error) < 8) {
                $error="Password should be more than 7 characters.";
            } 
            else if (strlen($error) <= 100) 
            {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
                    return "Only letters and numbers are allowed.";
                } else {
                    $error = "";
                }
            } else {
                $error = "Please fill in your password.";
            }
            return $error;
        }
    }
    public function pName($pName) {
        $error = $pName;
        if (!empty($error)) {
            if (!preg_match("/^[A-Za-z0-9.,\- ]+$/", $pName)) {
                $error = "Only alphabets are allowed!";
            } else {
                $error = ""; // If entered correctly, clear the value
            }
        } else {
            $error = "Fill in the field.";
        }
        return $error;
    }

    public function price($price) {
        $error = $price;
        if (!empty($error)) {
            if (!preg_match("/^\d+(\.\d{2})?$/", $price)) {                
                $error  = "The price format should be xxx or xxx.xx"; 

            } else {
                $error = ""; // If entered correctly, clear the value
            }
        } else {
            $error = "Fill in the price.";
        }
        return $error;
    }
    
    public function size($size) {
        $error = $size;
        if (!empty($error)) {
            if (!preg_match("/^(\d+(\.\d+)?)$/", $size)) {
                $error = "Only valid numbers (integers or decimals) are allowed!";
            } else {
                $error = ""; // If entered correctly, clear the value
            }
        } else {
            $error = "Fill in the size.";
        }
        return $error;
    }
    
    public function color($color) {
        $error = $color;
        if (!empty($error)) {
            if (!preg_match("/^[A-Za-z0-9.,\- ]+$/", $color)) {
                $error = "Only alphabets are allowed!";
            } else {
                $error = ""; // If entered correctly, clear the value
            }
        } else {
            $error = "Fill in the field.";
        }
        return $error;
    }

    public function qty($qty) {
        $error = $qty;
        if (!empty($error)) {
            if (!preg_match("/^[0-9]+$/", $qty)) {
                $error = "Only whole numbers are allowed!";
            } else {
                $error = ""; // If entered correctly, clear the value
            }
        } else {
            $error = "Fill in the quantity.";
        }
        return $error;
    }
    
    public function Offer($offer) {
        $error = $offer;
    
        if (empty($error)) {
            return "Fill in the offer code.";
        } else {
            $codeLength = strlen($error);
    
            if ($codeLength !== 6) {
                $error = "The code should be exactly six digits.";
            } else {
                if (!preg_match("/^[0-9A-Za-z]*$/", $offer)) {
                    $error = "Only numbers and alphabets are allowed.";
                } else {
                    $error = ""; 
                }
            }
            
            return $error;
        }
    }
    

    public function percent($percentage) {
        $error = $percentage;
    
        if (!empty($error)) {
            if (!preg_match("/^(\d+(\.\d+)?)$/", $percentage)) {
                $error = "Only valid numbers (integers or decimals) are allowed!";
            } else {
                // Convert the percentage to a float for range comparison
                $percentageFloat = (float)$percentage;
    
                // Check if the percentage is within the specified range
                if ($percentageFloat < 0.1 || $percentageFloat > 1) {
                    $error = "Percentage should be between 0.1 to 1 (0.1% and 100%).";
                } else {
                    $error = ""; // If entered correctly, clear the value
                }
            }
        } else {
            $error = "Fill in the percentage with decimals.";
        }
    
        return $error;
    }
    

}
   
?>