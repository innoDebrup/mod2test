<?php
require '../controller/LoginChecker.php';
require '../controller/PostProcess.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <!-- Unicons CSS -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="/CSS/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="/JS/home.js" ></script>
</head>

<body>
  <nav class="nav">
    <i class="uil uil-bars navOpenBtn"></i>
    <a href="#" class="logo">Great App</a>
    <div class="nav-links">
      <ul class="nav-links">
        <i class="uil uil-times navCloseBtn"></i>
        <li><a href="#">Home</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>

      <i class="uil uil-search search-icon" id="searchIcon"></i>
      <div class="search-box">
        <i class="uil uil-search search-icon"></i>
        <input type="text" placeholder="Search here..." />
      </div>
    </div>
    <div class="nav-links">
      <div><a href="/Profile">Profile</a></div>
      <div><a href="/Logout">Logout</a></div>
    </div>
  </nav>
  <div class="post-container">
    <h2>Create a Post</h2>
    <form action="/Home" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="content">Write something:</label>
        <textarea id="post-text" name="content" rows="4" cols="50"></textarea>
      </div>
      <div class="form-group">
        <label for="media">Upload an image:</label>
        <input type="file" id="post-image" name="media">
      </div>
      <button type="submit">Post</button>
    </form>
    <div id = 'post-error'>
      <h3><?php echo $post_err_msg; ?></h3>
    </div>
  </div>
  <div>
    <form>
      <input type="text" name="hiddenid" value="<?php echo $user_id?>" id="user-id" hidden>
    </form>
  </div>
  <div class="container">
    <h2 id="top-posts-header">Recent Posts</h2>
    <div class="posts-display">
      <?php foreach($post_arr as $post): ?>
        <?php require '../view/PostDisplay.php'; ?>
      <?php endforeach; ?>
      <div id="loaded-content"></div>
      <div id="load-message"></div>
      <div class="btn-con">
        <button id="more">See more</button>
      </div>
    </div>
  </div>
  <div id="debug"></div>
</body>

</html>
