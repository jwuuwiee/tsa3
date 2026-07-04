<?php
session_start();
require_once 'db_connect.php';

// Must be logged in to view this page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT firstname, middlename, lastname, birthday, email, contact, password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Safety check in case the account no longer exists
if (!$user) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$fullname = $user['firstname'] . " " . $user['middlename'] . " " . $user['lastname'];
$birthdayFormatted = date("F j, Y", strtotime($user['birthday']));

$pwErrors = [];
$pwSuccess = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {

    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $reenterPassword = trim($_POST['reenter_password'] ?? '');

    if ($currentPassword == "" || $newPassword == "" || $reenterPassword == "") {
        $pwErrors[] = "All password fields are required.";
    }

    if (empty($pwErrors) && !password_verify($currentPassword, $user['password'])) {
        $pwErrors[] = "Current password is not the same with the old password.";
    }

    if (empty($pwErrors) && $newPassword !== $reenterPassword) {
        $pwErrors[] = "New password and Re-Enter new password should be the same.";
    }

    if (empty($pwErrors)) {
        $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updateStmt->bind_param("si", $newHashed, $user_id);

        if ($updateStmt->execute()) {
            $pwSuccess = "Password successfully reset.";
            $user['password'] = $newHashed;
        } else {
            $pwErrors[] = "Something went wrong while updating your password.";
        }

        $updateStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Information Form</title>

<style>
body{
    font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;
    background:#ffd1dc;
    margin:0;
    padding:40px 20px;
    display:flex;
    justify-content:center;
}

.container{
    background:#fff;
    width:100%;
    max-width:420px;
    padding:25px 30px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
}

.top-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.top-row h2{
    margin:0;
    font-size:22px;
}

.top-row a{
    color:#3b82f6;
    text-decoration:none;
    font-weight:bold;
    font-size:14px;
}

hr{
    border:none;
    border-top:1px solid #e5e7eb;
    margin:15px 0;
}

.info-line{
    margin:8px 0;
}

.info-label{
    font-weight:bold;
}

.section-title{
    margin-top:20px;
    margin-bottom:10px;
    font-weight:bold;
    letter-spacing:.5px;
    color:#374151;
}

.form-group{
    margin-bottom:12px;
}

label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
    font-size:14px;
}

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

.success-box{
    margin-bottom:15px;
    background:#f0fdf4;
    border:1px solid #bbf7d0;
    color:#15803d;
    padding:12px;
    border-radius:8px;
    font-size:14px;
}
</style>
</head>
<body>

<div class="container">

<div class="top-row">
    <h2>User Information Form</h2>
    <a href="logout.php">Log-out</a>
</div>

<div class="info-line"><span class="info-label">Welcome <?php echo htmlspecialchars($fullname); ?></span></div>
<div class="info-line"><span class="info-label">Birthday:</span> <?php echo htmlspecialchars($birthdayFormatted); ?></div>
<div class="info-line"><span class="info-label">Contact Details</span></div>
<div class="info-line">&nbsp;&nbsp;<span class="info-label">Email:</span> <?php echo htmlspecialchars($user['email']); ?></div>
<div class="info-line">&nbsp;&nbsp;<span class="info-label">Contact:</span> <?php echo htmlspecialchars($user['contact']); ?></div>

<hr>

<div class="section-title">RESET PASSWORD</div>

<?php if(!empty($pwErrors)): ?>
<div class="error-box">
    <?php foreach($pwErrors as $error): ?>
        <div><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if($pwSuccess !== ""): ?>
<div class="success-box"><?php echo htmlspecialchars($pwSuccess); ?></div>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

<div class="form-group">
<label>Enter Current Password:</label>
<input type="password" name="current_password" required>
</div>

<div class="form-group">
<label>Enter New Password:</label>
<input type="password" name="new_password" required>
</div>

<div class="form-group">
<label>Re-Enter New Password:</label>
<input type="password" name="reenter_password" required>
</div>

<input type="submit" name="reset_password" value="Reset Password">

</form>

</div>

</body>
</html>