<?php
require __DIR__ . '/LoginChecker.php';
require __DIR__ . '/QueryCall.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  session_start();
  $name = $_POST['name'];
  $price = $_POST['price'];
  $id = $_SESSION['user_id'];
  $create->addStock($id, $name, $price);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CSS/profile.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="/JS/profile.js"></script>
  <title>Stock-Entry</title>
</head>

<body>
  <div>
    <a href="/" id="back-btn">Back</a>
  </div>
  <div class='container'>
    <div class="post-container">
    <form method="post" action="/stocks-entry">
        <label for="name">Stock Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="price">Stock Price:</label>
        <input type="number" id="price" name="price" required><br><br>
        <button type="submit" name="add">Add Stock</button>
    </form>
    </div>
  </div>
</body>

</html>
