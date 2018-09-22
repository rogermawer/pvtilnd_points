<?php


 require "constants.php";


 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $rname=test_input($_POST['receiver']);
     $comment=test_input($_POST['comment']);
     $new_points=(int)($_POST['points']);
     $giver=test_input($_POST['giver']);
    
    function newUserPoints($user){
        include "constants.php";
        $users_points = "SELECT points FROM members WHERE user_name='$user'";
        $users_points_result = mysqli_query($con, $users_points);
        $row = mysqli_fetch_array($users_points_result);
        $old_points = $row['points'];
        $new_points=(int)($_POST['points']);
        return $new_points + $old_points;
    }

     $updated_points = newUserPoints($rname);
     
     $q=mysqli_query($con,"UPDATE `members` SET points='$updated_points' WHERE user_name='$rname'");
     if($q){
      echo "success";
     }else{
      echo "error";
     };
     archive($giver, $rname, $new_points);  
 }else{
     echo "You must be logged in";
 }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 
function archive($givername, $rname, $new_points){
        require 'constants.php';
        $con = new mysqli($servername, $username, $password, $DBname);
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        } else {
            //echo "connection successfull";
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $receivername = $rname;
            $new_points=(int)($_POST['points']);
            date_default_timezone_set('America/Los_Angeles');
            $comment = test_input($_POST["comment"]);
            $timestamp = date('Y.m.d.h.i.s');
            
            if (!(empty($comment))){
                $updateArchive = "INSERT INTO awarded_points (giver, receiver, points, comment, time)VALUES ('$givername','$receivername', '$new_points', '$comment', '$timestamp')";
                if ($con->query($updateArchive) === TRUE) {
                    echo("success adding comment");
                }else {
                    echo("error adding comment!");
                }
            }else{
                $updateArchive = "INSERT INTO awarded_points (giver, receiver, points, time)
                VALUES ('$givername','$receivername', '$new_points', '$timestamp')";
                if ($con->query($updateArchive) === TRUE) {
                    echo "comment was empty!<br><br>";
                }else {
                    echo "error adding comment!";
                }
            }
        }
    }
?>

