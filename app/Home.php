<?php
require __DIR__ . '/LoginChecker.php';
require __DIR__ . '/QueryCall.php';

$stocks_arr = $read->getStocks();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $delete->removeStock($_POST['u_id'],$_POST['s_id']);
  header('Location: /home');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="/CSS/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <!-- Unicons CSS -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="/JS/home.js"></script>
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
      <div><a href="/stocks-entry">Add Stock</a></div>
      <div><a href="/logout">Logout</a></div>
    </div>
  </nav>
  <div class="container">
    <h2 id="top-posts-header">All Stocks</h2>
    <div class="posts-display">
      <div>
        <div>
          <table>
            <thead>
              <tr>
                <th>Stock Name</th>
                <th>Stock Price</th>
                <th>User Name</th>
                <th>Date Added</th>
                <th>Last Edited</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($stocks_arr as $stock) : ?>
                <?php require __DIR__ . '/StocksDisplay.php'; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div id="loaded-content"></div>
      <div id="load-message"></div>
    </div>
  </div>
  <div id="debug"></div>
</body>

</html>
