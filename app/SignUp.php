<?php

require __DIR__ . '/QueryCall.php';
require_once __DIR__ . '/Validate.php';
session_start();
$not_duplicate = TRUE;
$valid_password = TRUE;
$valid_input = TRUE;
$success = FALSE;
$message = '';
$validator = new Validate();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_SESSION['otp'])) {
    $user_name = htmlspecialchars($_POST['user_name']);
    $email = $_SESSION['email'];
    $password = htmlspecialchars($_POST['password']);
    $otp = $_SESSION['otp'];
    $entered_otp = $_POST['otp'];
    if (!empty($user_name) && !empty($email) && !empty($password)) {
      $not_duplicate = $read->checkUser($user_name, $email);
      $valid_password = $validator->validPassword($password);
      if ($not_duplicate && $valid_password) {
        if ($entered_otp == $otp){
          $create->addUser($user_name, $email, $password);
          $message = 'User Created Successfully!! Please proceed to Login!';
          $success = TRUE;
        }
        else {
          $message = 'Wrong OTP! Please Retry!!';
        }
      }
      elseif (!$not_duplicate) {
        $message = 'Username already exists!!! Please retry with another';
      }
      else {
        $message = $validator->getPasswordErr();
      }
    }
    else {
      $valid_input = FALSE;
    }
  }
  else {
    $message = "Please verify your email through OTP by clicking Get OTP after entering your email address";
    $valid_input = FALSE;
  }
  session_unset();
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CSS/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="/JS/script.js"></script>
  <title>Sign Up</title>
</head>

<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Sign Up Now!
        </h1>
      </div>
      <div class="vert-form">
        <form action="/signup" method="post">
          <label for="user_name">Username</label>
          <input type="text" name="user_name">
          <label for="email">Email</label>
          <input type="text" name="email" id="email">
          <label for="password">Password</label>
          <input type="password" name="password">
          <div id="otpcon">
            <label for="otp">Email OTP</label>
            <input type="text" name='otp' id="otp">
          </div>
          <div id="getotpcon">
            <input type="button" value="Get OTP" id="check">
          </div>
          <div id="message"></div>
          <div class="options">
            <ul>
              <li><a href="/">Go Back to Login</a></li>
            </ul>
          </div>

          <input type="submit" value="Submit">
        </form>
        <div class="center">
          <h2><?php if (!$valid_input) {echo "Please fill all fields correctly!";} ?></h2>
          <h3 id="response"></h3>
          <h4><?php echo $message ?></h4>
          <?php if ($success) : ?>
            <a href="/">Login</a>
          <?php endif; ?>
        </div>  
      </div>
    </div>
  </div>
</body>

</html>
