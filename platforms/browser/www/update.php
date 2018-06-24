
<?php
    require_once 'scripts/constants.php';




$fname = $lname = $uname = "";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $uname = test_input($_POST["uname"]);
  $new_points = (int)($_POST["points"]);  
  
  $users_points = "SELECT points FROM members WHERE user_name='$uname'";
  $users_points_result = mysqli_query($conn, $users_points);
  $row = mysqli_fetch_array($users_points_result);
  $old_points = $row['points'];
  

    
    //find all members and put in array
    $find_user = "SELECT user_name FROM members";
    $storeArray = Array();
    $find_user_result = mysqli_query($conn, $find_user);
    while($row = mysqli_fetch_assoc($find_user_result)){
        $storeArray[] =  $row['user_name'];  
    }
    
  session_start();
    $givername = $_SESSION['username'];
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && (!($_SESSION['username'] == $uname))) {
        if (in_array($uname,$storeArray)){
            
            if ($new_points > 0) {
                //add points to db
                $updated_points = $old_points + $new_points;
                $userUpdate = "UPDATE members SET points='$updated_points' WHERE user_name='$uname'";
                if ($conn->query($userUpdate) === TRUE) {
                    echo "Successfully awarded <b>$new_points</b> points to <b>$uname</b>!<br><br>";
                    echo '<a href="loginhtml_V2.php">Do another?</a>';
                    archive($givername, $uname, $new_points);
                }else {
                    echo "Error awarding points!";
                }
            }elseif ($new_points < 0){
                //minus points and update db
                $updated_points = $old_points + $new_points;
                $userUpdate = "UPDATE members SET points='$updated_points' WHERE user_name='$uname'";
                if ($conn->query($userUpdate) === TRUE) {
                    echo "Successfully took away points! Shit man, what'd he do?<br><br>";
                    echo '<a href="loginhtml_V2.php">Do another?</a>';
                    archive($givername, $uname, $new_points);
                }else {
                    echo "Error!";
                }
            }else {
                echo "Ok, I guess you can give someone 0 points? Whatever man.<br><br>";
                echo '<a href="loginhtml_V2.php">Do another?</a>';
                    archive($givername, $uname, $new_points);
            }
        }else{
            echo "No user found by that name!<br><br>";
            echo '<a href="loginhtml_V2.php">Try again</a>';
        }
    }else {
        echo "Nice try, but you can't give points to yourself!<br><br>";
        echo '<p>Don\'t be sneaky.<br><br><a href="loginhtml_V2.php">Try again.</a></p>';
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function archive($givername, $uname, $new_points){
        require 'scripts/constants.php';
        $conn = new mysqli($servername, $username, $password, $DBname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            //echo "connection successfull";
        }
        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
            $receivername = $uname;
            date_default_timezone_set('America/Los_Angeles');
            $comment = test_input($_POST["comment"]);
            $timestamp = date('Y.m.d.h.i.s');
            
            if (!(empty($comment))){
                $updateArchive = "INSERT INTO awarded_points (giver, receiver, points, comment, time)VALUES ('$givername','$receivername', '$new_points', '$comment', '$timestamp')";
                if ($conn->query($updateArchive) === TRUE) {
                    header("location:loginhtml_V2.php");
                }else {
                    echo "error adding comment!";
                }
            }else{
                $updateArchive = "INSERT INTO awarded_points (giver, receiver, points, time)
                VALUES ('$givername','$receivername', '$new_points', '$timestamp')";
                if ($conn->query($updateArchive) === TRUE) {
                    echo "comment was empty!<br><br>";
                }else {
                    echo "error adding comment!";
                }
            }
        }
    }






    

    $conn->close();

?>
     
        
<html>
    
    <body>
        <br><br>
     
        <a href="logout.php">Log out</a>
    </body>
</html>
