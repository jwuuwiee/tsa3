<?php
session_start();
require_once 'db_connect.php';

// If already logged in, go straight to the user info page
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$username = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username == "") $errors[] = "Username is required.";
    if ($password == "") $errors[] = "Password is required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, firstname, middlename, lastname, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {

                // Credentials are correct - start the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $row['firstname'] . " " . $row['middlename'] . " " . $row['lastname'];

                header("Location: home.php");
                exit;
            } else {
                $errors[] = "Incorrect username or password.";
            }
        } else {
            $errors[] = "Incorrect username or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log-In Form</title>

<style>
body{
    font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;
    background:#ffd1dc;
    margin:0;
    padding:60px 20px;
    display:flex;
    justify-content:center;
}

.container{
    background:#fff;
    width:100%;
    max-width:320px;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    margin:0 0 20px 0;
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
    border:1px solid #b64141;
    border-radius:6px;
    box-sizing:border-box;
}

input[type=submit]{
    width:100%;
    padding:12px;
    background:#9ca3af;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
    margin-top:5px;
}

input[type=submit]:hover{
    background:#6b7280;
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:12px;
    color:#888;
}

.error-box{
    margin-bottom:15px;
    background:#fee2e2;
    border:1px solid #ef4444;
    color:#b91c1c;
    padding:12px;
    border-radius:8px;
    font-size:14px;
}

.register-link{
    text-align:center;
    margin-top:15px;
    font-size:14px;
}

.register-link a{
    color:#3b82f6;
    text-decoration:none;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="container">

<h2>Log-In Form</h2>

<?php if(!empty($errors)): ?>
<div class="error-box">
    <?php foreach($errors as $error): ?>
        <div><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

<div class="form-group">
<label>Username</label>
<input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password" required>
</div>

<input type="submit" name="submit" value="Login">

</form>

<div class="register-link">
    Don't have an account? <a href="register.php">Register here</a>
</div>

</div>

</body>
</html>