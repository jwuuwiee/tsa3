<?php
if(isset($_POST['login'])){

    $user = $_POST['username'];
    $pass = $_POST['password'];

    if(isset($_POST['remember'])){
        setcookie("username", $user, time()+3600);
        setcookie("password", $pass, time()+3600);

        // Update current values immediately
        $_COOKIE['username'] = $user;
        $_COOKIE['password'] = $pass;
    } else {
        // Remove cookies if Remember Me is not checked
        setcookie("username", "", time()-3600);
        setcookie("password", "", time()-3600);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>

<style>
body{
    font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;
    background:#ffd1dc;
    margin:0;
    padding:40px;
    display:flex;
    justify-content:center;
}

.container{
    width:400px;
    background:#fff;
    padding:30px;
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

.remember{
    margin:15px 0;
}

input[type=submit]{
    width:100%;
    padding:12px;
    background:#3b82f6;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

input[type=submit]:hover{
    background:#2563eb;
}
</style>

</head>
<body>

<div class="container">

<h2>🌸 Login 🌸</h2>

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

<div class="remember">
<label>
<input type="checkbox" name="remember">
Remember Me
</label>
</div>

<input type="submit" name="login" value="Login">

</form>

</div>

</body>
</html>