<?php
require __DIR__ . '/LoginChecker.php';
require __DIR__ . '/QueryCall.php';
$user_info = $read->getUserInfo($_SESSION['user_mail']);
$user_id = $user_info['user_id'];
$user_name = $user_info['user_name'];
$email = $user_info['email'];
$profile_details = $read->getUserDetails($user_id);
$first_name = $profile_details['first_name'];
$last_name = $profile_details['last_name'];
$country = $profile_details['country'];
$image = $profile_details['profile_pic'];
$error = FALSE;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['f_name'])) {
    $update->editFirstName($user_id, htmlspecialchars($_POST['f_name']));
    header('Location: /profile');
  }
  if (isset($_POST['l_name'])) {
    $update->editLastName($user_id, htmlspecialchars($_POST['l_name']));
    header('Location: /profile');
  }
  if (isset($_POST['country'])) {
    $update->editCountry($user_id, htmlspecialchars($_POST['country']));
    header('Location: /profile');
  }
  if (isset($_POST['u_name'])) {
    $update->changeUserName($user_id, htmlspecialchars($_POST['u_name']));
    header('Location: /profile');
  }
  if (isset($_FILES['pic'])) {
    if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
      $mime_type = mime_content_type($_FILES['pic']['tmp_name']);
      $allowed_file_types = ['image/png', 'image/jpeg', 'application/pdf'];
      if (! in_array($mime_type, $allowed_file_types)) {
        $error = TRUE;
      }
      else {
        $img = file_get_contents($_FILES['pic']['tmp_name']);
        $update->editProfile($user_id, $img);
        header('Location: /profile');
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style><?php require '../view/CSS/profile.css';?></style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script><?php require '../view/JS/profile.js';?></script>
  <title>Profile</title>
</head>

<body>
  <div class='container'>
    <div>
      <div>
        <a href="/home" id="back-btn">Back</a>
      </div>
      <div class="profile">
        <div class="center col">
          <div class='pic'>
            <?php if (empty($image)) : ?>
              <img src="assets/dummy.jpg" alt="Profile">
            <?php else: ?>
              <img src="data:image;base64, <?php echo(base64_encode($image));?>" alt="Profile">
            <?php endif; ?>
          </div>
          <a class='edit'>Edit</a>
          <form action="/profile" method="post" enctype="multipart/form-data">
            <input type="file" name="pic" accept="image/png, image/jpg, image/jpeg, image/webp">
            <input type="submit" value="Upload">
          </form>
        </div>
        <div class="user-name">
          <h1><?php echo $user_name; ?></h1>
          <div>
            <a class="edit">Edit UserName</a>
            <form action="/profile" method="post" class="edit-input">
              <input type="text" name="u_name" placeholder="Enter Your new User-Name" maxlength="30">
              <input type="submit" value="Submit">
            </form>
          </div>
        </div>
      <?php if ($error): ?>
        <div class="error">
          <h2>File Type not allowed.</h2>
        </div>
      <?php endif; ?>
      <table id="main-table">
        <tbody>
          <tr>
            <th>Email</th>
            <td><?php echo $email; ?></td>
            <td></td>
          </tr>
          <tr>
            <th>First Name</th>
            <td><?php echo (empty($first_name) ? 'Not Set' : $first_name); ?></td>
            <td>
              <a class="edit">Edit</a>
              <form action="/profile" method="post" class="edit-input">
                <input type="text" name="f_name" placeholder="Enter Your First Name" maxlength="30">
                <input type="submit" value="Submit">
              </form>
            </td>
          </tr>
          
          <tr>
            <th>Last Name</th>
            <td><?php echo (empty($last_name) ? 'Not Set' : $last_name); ?></td>
            <td>
              <a class="edit">Edit</a>
              <form action="/profile" method="post" class="edit-input">
                <input type="text" name="l_name" placeholder="Enter Your Last Name" maxlength="30">
                <input type="submit" value="Submit">
              </form>
            </td>
          </tr>
          <tr>
            <th>Country</th>
            <td><?php echo (empty($country) ? 'Not Set' : $country); ?></td>
            <td>
              <a class="edit">Edit</a>
              <form action="/profile" method="post" class="edit-input">
                <input type="text" name="country" placeholder="Enter Your Country Name" maxlength="30">
                <input type="submit" value="Submit">
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
