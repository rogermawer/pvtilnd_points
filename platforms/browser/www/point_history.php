
<?php
    require_once 'constants.php';

//validation

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  
  $givername = $_SESSION['username'];
  $receivername = $uname;
  $minus_or_plus = $_POST['pointvalue'];
  $new_points = $_POST["points"];
    
            $sql = "INSERT INTO awarded_points (giver, receiver, plus_or_min, points)
            VALUES ('$givername','$receivername', '$minus_or_plus', '$new_points')";
            if ($con->query($sql) === TRUE) {
                echo "Point giving archived!<br><br>";
                
                
            }else {
                echo "Error archiving points!";
        }
        
}





    

    $con->close();

?>
     
        
<html>
    
    <body>
        <br><br>
     <a href="index.html">Go back</a>
    </body>
</html>
