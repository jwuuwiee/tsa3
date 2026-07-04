<?php
$firstname = $middlename = $lastname = "";
$username = $password = $confirm = "";
$birthday = $email = $contact = "";

$resultFirstname = $resultMiddlename = $resultLastname = "";
$resultUsername = $resultPassword = "";
$resultBirthday = $resultEmail = $resultContact = "";

$submitted = false;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])) {

    $firstname = trim($_GET['firstname'] ?? '');
    $middlename = trim($_GET['middlename'] ?? '');
    $lastname = trim($_GET['lastname'] ?? '');
    $username = trim($_GET['username'] ?? '');
    $password = trim($_GET['password'] ?? '');
    $confirm = trim($_GET['confirm'] ?? '');
    $birthday = trim($_GET['birthday'] ?? '');
    $email = trim($_GET['email'] ?? '');
    $contact = trim($_GET['contact'] ?? '');

    if ($firstname == "") $errors[] = "First Name is required.";
    if ($middlename == "") $errors[] = "Middle Name is required.";
    if ($lastname == "") $errors[] = "Last Name is required.";
    if ($username == "") $errors[] = "Username is required.";
    if ($password == "") $errors[] = "Password is required.";
    if ($confirm == "") $errors[] = "Confirm Password is required.";
    if ($birthday == "") $errors[] = "Birthday is required.";
    if ($email == "") $errors[] = "Email is required.";
    if ($contact == "") $errors[] = "Contact Number is required.";

    if ($password != $confirm) {
        $errors[] = "Password and Confirm Password are not the same.";
    }

    if (empty($errors)) {

        $resultFirstname = $firstname;
        $resultMiddlename = $middlename;
        $resultLastname = $lastname;
        $resultUsername = $username;
        $resultPassword = $password;
        $resultBirthday = $birthday;
        $resultEmail = $email;
        $resultContact = $contact;

        $submitted = true;

        $firstname = "";
        $middlename = "";
        $lastname = "";
        $username = "";
        $password = "";
        $confirm = "";
        $birthday = "";
        $email = "";
        $contact = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>

<style>
body{
    font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;
    background: #ffd1dc ;
    margin:0;
    padding:40px 20px;
    display:flex;
    justify-content:center;
}

.container{
    background:#fff;
    width:100%;
    max-width:450px;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
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
input[type=password],
input[type=email],
input[type=date]{
    width:100%;
    padding:10px;
    border:1px solid #b64141;
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
    font-size:16px;
}

input[type=submit]:hover{
    background:#2563eb;
}

.output-box{
    margin-top:25px;
    padding:20px;
    background:#f0fdf4;
    border:1px solid #bbf7d0;
    border-radius:8px;
}

.output-box h3{
    margin-top:0;
}

.output-line{
    padding:6px 0;
    border-bottom:1px dashed #ccc;
}

.output-line:last-child{
    border-bottom:none;
}

.label-text{
    font-weight:bold;
}

.error-box{
    margin-bottom:20px;
    background:#fee2e2;
    border:1px solid #ef4444;
    color:#b91c1c;
    padding:15px;
    border-radius:8px;
}
</style>

</head>
<body>

<div class="container">

<h2>🌸 Registration Form 🌸</h2>

<?php if(!empty($errors)): ?>
<div class="error-box">
    <?php foreach($errors as $error): ?>
        <div><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

<div class="form-group">
<label>First Name</label>
<input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
</div>

<div class="form-group">
<label>Middle Name</label>
<input type="text" name="middlename" value="<?php echo htmlspecialchars($middlename); ?>" required>
</div>

<div class="form-group">
<label>Last Name</label>
<input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
</div>

<div class="form-group">
<label>Username</label>
<input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password" required>
</div>

<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="confirm" required>
</div>

<div class="form-group">
<label>Birthday</label>
<input type="date" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
</div>

<div class="form-group">
<label>Contact Number</label>
<input type="text" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
</div>

<input type="submit" name="submit" value="Register">

</form>

<?php if($submitted): ?>

<div class="output-box">

<h3>Registration Details</h3>

<div class="output-line">
    <span class="label-text">Full Name:</span>
    <?php echo htmlspecialchars($resultFirstname . " " . $resultMiddlename . " " . $resultLastname); ?>
</div>

<div class="output-line">
    <span class="label-text">Username:</span>
    <?php echo htmlspecialchars($resultUsername); ?>
</div>

<div class="output-line">
    <span class="label-text">Password:</span>
    <?php echo htmlspecialchars($resultPassword); ?>
</div>

<div class="output-line">
    <span class="label-text">Birthday:</span>
    <?php echo htmlspecialchars($resultBirthday); ?>
</div>

<div class="output-line">
    <span class="label-text">Email:</span>
    <?php echo htmlspecialchars($resultEmail); ?>
</div>

<div class="output-line">
    <span class="label-text">Contact Number:</span>
    <?php echo htmlspecialchars($resultContact); ?>
</div>

</div>

<?php endif; ?>

</body>
</html>
