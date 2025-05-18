
<?php
include "include/config.php";
if(isset($_POST["submit"])){

// Function to validate data
function validate($data){
return strip_tags(htmlspecialchars($data));
}


// Check if email exists
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE email =:email");
$stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
$stmt->execute();
$getEmail = $stmt->fetch();
$countMail = $getEmail["count"];

// Check if username exists
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE username =:username");
$stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
$stmt->execute();
$getUser = $stmt->fetch();
$countUser = $getUser["count"];



if(empty($_POST["username"])){
$error = "Enter username";
}
elseif(!preg_match("/^[a-zA-Z0-9]+$/", $_POST["username"])){
$error = "Enter a valid username";
}
elseif(empty($_POST["email"])){
$error = "Enter email";
}
elseif(empty($_POST["password"])){
$error = "Enter password";
}
elseif($countUser > 0){
$error = "Username already taken";
}
elseif($countMail > 0){
$error = "Email already taken";
}
else{

$username = validate($_POST["username"]);
$email = validate($_POST["email"]);
$password = $_POST["password"];


$password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, password) 
                    VALUES(:username, :email, :password)");
$stmt->bindParam(":username", $username, PDO::PARAM_STR);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->bindParam(":password", $password, PDO::PARAM_STR);
$stmt->execute();

if($stmt){
$success = "Registered Successfully";
}
}


}

?>


?>

<!Doctype html>
<head>
<link rel="stylesheet" href="css/myloginpage.css">
<!-- <script src="Javascript/classwork.js"></script> -->
<meta name="viewport" content="width=device-width, initial-content=1">
</head>

<body>
<div class="maincon">
<form action="" method="POST"> 
<h3 id="error" class="hide"><?php if(isset($error)){echo $error;}?></h3>
<h3 id="success"><?php if(isset($success)){echo $success;}?></h3>

<img src="images/logo2.png" width="70px">
<input type="text" name="username" value="<?php if(!empty($username)){echo $username;}?>" placeholder="Enter Username"><br>
<input type="text" name="email" value="<?php if(!empty($email)){echo $email;}?>" placeholder="Enter email address"><br>
<input type="password" name="password" value="<?php if(!empty($password)){echo $password;}?>" placeholder="Enter Password"><br>
<button id="login"type="login" name="submit">Submit</button><br>
<!-- <button type="reset" id="reset" name = "reset">Reset</button> -->
</form>
</div>
<!-- <button id="toggleBtn" class="arrow-button">
<span class="arrow">&Hat;</span>
</button><br>

<div id="buttons" style="display: none;">
<div id = "items"><p>
<div><a href="#">Forgot username click me</div></a><br>
<div><a href="#">Forgot password click me</div></a><br>
<div><a href="#">Return to index page</div></a><br>
</div> -->

<script>
const button = document.getElementById('toggleBtn');
const arrow = button.querySelector('.arrow');
const buttons = document.getElementById('buttons');

button.addEventListener('click', () => {
arrow.classList.toggle('rotate');
buttons.style.display = buttons.style.display === 'block' ? 'none' : 'block';
});

</script>
</body>
</html>


