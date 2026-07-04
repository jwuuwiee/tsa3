<?php
session_start();

// Prevent logged-in users from accessing the login page
if(isset($_SESSION['username'])){
    header("Location: home.php");
    exit();
}

// Static username and password
$correctUsername = "jwuuwiee";
$correctPassword = "123";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Remember Me
    if(isset($_POST['remember'])){
        setcookie("username",$username,time()+3600);
        setcookie("password",$password,time()+3600);

        // Update cookies immediately
        $_COOKIE['username'] = $username;
        $_COOKIE['password'] = $password;
    }else{
        // Delete cookies
        setcookie("username","",time()-3600);
        setcookie("password","",time()-3600);
    }

    if($username == $correctUsername && $password == $correctPassword){

        $_SESSION['username'] = $username;

        header("Location: home.php");
        exit();

    }else{
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body{
font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;
background:#ffd1dc;
display:flex;
justify-content:center;
padding:40px;
}

.container{
background:white;
padding:30px;
width:400px;
border-radius:12px;
box-shadow:0 4px 10px rgba(0,0,0,.1);
}

h2{
text-align:center;
}

.form-group{
margin-bottom:15px;
}

label{
display:block;
margin-bottom:5px;
font-weight:bold;
}

input[type=text],
input[type=password]{
width:100%;
padding:10px;
border:1px solid #ccc;
border-radius:6px;
box-sizing:border-box;
}

input[type=submit]{
width:100%;
padding:12px;
background:#3b82f6;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

input[type=submit]:hover{
background:#2563eb;
}

.error{
margin-bottom:15px;
padding:10px;
background:#fee2e2;
color:#b91c1c;
border-radius:6px;
}
</style>

</head>

<body>

<div class="container">

<h2>🌸 Login 🌸</h2>

<?php
if(isset($error)){
echo "<div class='error'>$error</div>";
}
?>

<form method="post">

<div class="form-group">
<label>Username</label>
<input type="text" name="username"
value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>">
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password"
value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>">
</div>

<label>
<input type="checkbox" name="remember">
Remember Me
</label>

<br><br>

<input type="submit" name="login" value="Login">

</form>

</div>

</body>
</html>