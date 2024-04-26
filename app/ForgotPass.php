<?php
require_once __DIR__ . '/QueryCall.php';
require_once __DIR__ . '/SendMail.php';

$send_mail = new SendMail();
$sent = 0;
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $email = htmlspecialchars($_POST['email']);
  $email_present = $read->checkEmail($email);
  // Send Reset Link to the email only if it is registered.
  if ($email_present) {
    $update->addToken($email);
    $token_arr = $read->getToken($email);
    $reset_link = 'http://mod2test/resetpass?token='.$token_arr['reset_token'];
    $send_mail->setContent($reset_link);
    $send_mail->sendResetMail($email);
    $sent = 1;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="/CSS/style.css">
</head>

<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Forgot Password
        </h1>
      </div>
      <div class="vert-form">
        <form action="/forgotpass" method="post">
          <label for="email">Email</label>
          <input type="email" name="email" required>
          <div class="options">
            <ul>
              <li><a href="/">Go Back to Login</a></li>
            </ul>
          </div>
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>
    <?php if ($sent) : ?>
      <div class="center">
        <h2>Reset Link sent!!! Check your mail !</h2>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>
