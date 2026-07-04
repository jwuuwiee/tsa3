<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Home</title>

<style>

body{
font-family:Arial;
background:#ffd1dc;
text-align:center;
padding-top:100px;
}

.container{
background:white;
display:inline-block;
padding:40px;
border-radius:12px;
box-shadow:0 4px 10px rgba(0,0,0,.1);
}

a{
display:inline-block;
margin-top:20px;
background:#ef4444;
padding:10px 20px;
color:white;
text-decoration:none;
border-radius:6px;
}

a:hover{
background:#dc2626;
}

</style>

</head>

<body>

<div class="container">

<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

<p>You are now logged in.</p>

<a href="logout.php">Logout</a>

</div>

</body>

</html>
