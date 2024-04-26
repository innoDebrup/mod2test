<?php
require_once __DIR__ . '/LinkedInAPIv2.php';
$url = parse_url($_SERVER['REQUEST_URI']);
$path = $url['path'];
$query = '';
$linked_in = new LinkedInAPIv2();
if (isset($url['query'])) {
  $query = $url['query'];
}
// var_dump(http_response_code());
switch ($path) {
  case '/':
  case '/index':
  case '/login':
    require __DIR__ . '/Login.php';
    break;
  case '/signup':
    require __DIR__ . '/SignUp.php';
    break;
  case '/forgotpass':
    require __DIR__ . '/ForgotPass.php';
    break;
  case '/resetpass':
    require __DIR__ . '/ResetPass.php';
    break;
  case '/home':
    require __DIR__ .'/Home.php';
    break;
  case '/logout':
    require __DIR__ . '/Logout.php';
    break;
  case '/profile':
    require __DIR__ . '/Profile.php';
    break;
  default:
    require __DIR__ . '/404.php';
}