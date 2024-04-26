<?php
require_once __DIR__ . '/../OTP.php';

session_start();
$success = FALSE;
$msg = '';
$valid_email = TRUE;
$otp_process = new OTP();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = htmlspecialchars($_POST['email']);
  if (!empty($email) && (!isset($_SESSION['email']) || $_SESSION['email'] != $email)) {
    $valid_email = $otp_process->validateMail($email);
    $duplicate = $otp_process->checkDuplicate($email);
    if ($valid_email && !$duplicate) {
      $otp = $otp_process->genOTP();
      $otp_process->sendOTP($email, $otp);
      $msg = 'OTP sent successfully! Please check your Mail!';
      $_SESSION['otp'] = $otp;
      $_SESSION['email'] = $email;
    }
    elseif (!$valid_email) {
      $msg = 'Invalid Email';
      session_unset();
      session_destroy();
    }
    else {
      $msg = 'Email already exists!!';
      session_unset();
      session_destroy();
    }
  }
  elseif (isset($_SESSION['email'])) {
    $otp = $otp_process->genOTP();
    $otp = $otp_process->sendOTP($email, $otp);
    $msg = 'OTP sent successfully! Please check your Mail!';
    $_SESSION['otp'] = $otp;
  }
  else {
    $msg = 'Please Enter your Email Address';
    session_unset();
    session_destroy();
  }
}
echo $msg;
