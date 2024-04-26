<?php
session_start();
if (isset($_SESSION['user_mail'])) {
  session_unset();
  session_destroy();
}
header('Location: /');
