<?php
require_once __DIR__ . '/QueryCall.php';
require_once __DIR__ . '/Validate.php';

$reset = 0;
$message = '';
$validator = new Validate();
session_start();

if (!empty($query)) {
  $param = explode('=', $query);
  $_SESSION['token'] = $param[1];
}
else{
  $message = 'Invalid Link!! Please retry forgot password process !!';
}
if (isset($_SESSION['token'])) {
  $token = $_SESSION['token'];
  $returned_array = $read->checkToken($token);
  if ($returned_array) {
    $user_id = $returned_array['user_id'];
    $token_timer = strtotime($returned_array['token_timer']);
    if ($token_timer <= time()) {
      $message = 'The link has expired. Please retry forgot password !!';
    }
    else {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];
        if ($validator->validPassword($password)) {
          $password_hash = password_hash($password, PASSWORD_DEFAULT);
          $update->resetPass($user_id, $password_hash);
          $message = 'Password Reset Successfully! Please Login again!';
          $reset = 1;
        }
        else {
          $message = $validator->getPasswordErr();
        }
      }
    }
  }
  else {
    $message = 'Invalid Link!! Please retry forgot password process !!';
    session_unset();
    session_destroy();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CSS/style.css">
  <title>Forgot</title>
</head>
<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Reset Password
        </h1>
      </div>
      <?php if (!$reset): ?>
      <div class="vert-form">
        <form action="/resetpass" method="post">
          <label for="password">New Password</label>
          <input type="password" name="password">
          <input type="submit" value="Submit">
        </form>
        <div>
          <?php echo $message; ?>
        </div>
      </div>
      <?php endif;?>
      <?php if($reset): ?>
        <?php 
        session_unset();
        session_destroy();
        ?>
        <div class="center">
          <h1><?php echo $message; ?></h1>
          <a href='/'>Go to Login page</a>
        </div>  
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
