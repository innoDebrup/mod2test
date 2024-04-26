<?php
  require __DIR__ . '/QueryCall.php';
  session_start();
  if (isset($_SESSION['user_mail'])) {
    header('Location: /home');
  }
  $invalid = FALSE;
  $password_msg = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['LinkedIn'])){
      $linked_in->authorize();
    }
    else{
      $user_mail = $_POST['user_mail'];
      $password = $_POST['password'];
      $password_hash = $read->getPass($user_mail);
      if (password_verify($password, $password_hash)) {
        header('Location: /home');
        session_start();
        $_SESSION['user_mail'] = $user_mail;
      }
      else {
        $invalid = TRUE;
        if ($password_hash == NULL) {
          $password_msg = 'Your password is not set!! Please set it through the "Forgot your Password?" link';
        }
      }
    }
  }
  elseif (isset($_GET['code'])) {
    $linked_in->getAccess($_GET['code']);
    $response = $linked_in->getInfo();
    $response_error = $linked_in->getError();
    $user_email = $user_name = $response['email'];
    if (!$read->checkEmail($user_email)) {
      $create->addUser($user_name, $user_email, NULL);
      header('Location: /home');
      $user_mail = $user_email;
    }
    session_start();
    $_SESSION['user_mail'] = $user_email;
    header('Location: /home');
    echo $response_error;
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CSS/style.css">
  
  <title>Login Page</title>
</head>

<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Login
        </h1>
      </div>
      <div class="center">

      </div>
      <div class="vert-form">
        <form action="/" method="post">
          <label for="user_mail">Username/Email</label>
          <input type="text" name="user_mail" placeholder="Enter your username or email." required>
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="Enter your password." required>
          <div class="options">
            <ul>
              <li>New Here? <a href="/signup">Create an Account</a></li>
              <li><a href="/forgotpass">Forgot your Password? </a></li>
            </ul>
          </div>
          <input type="submit" value="Sign-In">
        </form>
        <form action="/" method="post">
              <input type="submit" name="LinkedIn" value="Sign-in with LinkedIn" id="linkedin">
        </form>
        <?php if ($invalid) : ?>
          <div class="center">
            <h2>Invalid Username/Email or Password.</h2><br>
            <h2><?php echo $password_msg; ?></h2>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>
