<?php
session_start();
include("DBConnect.php");

$username=$_SESSION['username'];

$current=$_POST['current'];
$new=$_POST['new'];
$confirm=$_POST['confirm'];

$sql="SELECT * FROM users
WHERE username='$username'";

$result=mysqli_query($conn,$sql);

$user=mysqli_fetch_assoc($result);

if($current!=$user['password']){

echo "Current password is incorrect.";

}elseif($new!=$confirm){

echo "New password and Re-enter password are not the same.";

}else{

$update="UPDATE users
SET password='$new'
WHERE username='$username'";

mysqli_query($conn,$update);

echo "Password Successfully Updated.";

}

echo "<br><br>";

echo "<a href='home.php'>Back</a>";
?>