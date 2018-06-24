<?php

    require_once 'constants.php';


//validation

$fname = $lname = $uname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $uname = test_input($_POST["uname"]);
  $pword = test_input($_POST["password"]);
    
    
    
    //LOGIN
  $find_pass = "SELECT pass_word FROM members WHERE user_name='$uname'";
  $find_pass_result = mysqli_query($con, $find_pass);
  $row = mysqli_fetch_array($find_pass_result);
  $reslut = $row['pass_word'];
    
    //find all members and put in array
    $find_user = "SELECT user_name FROM members";
    $storeArray = Array();
    $find_user_result = mysqli_query($con, $find_user);
    while($row = mysqli_fetch_assoc($find_user_result)){
        $storeArray[] =  $row['user_name'];  
    }
    if (in_array($uname,$storeArray)){
        if(password_verify($pword, $reslut)) {
            return true;
            
        }else{
            throw new Exception("Wrong Password");
        }
        if(empty($uname)) {
            throw new Exception("No username input");

        }else{

        }
    }else{
        throw new Exception("No user found by that name");
    }
    
    
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



    

    $con->close();

?>
     
        

