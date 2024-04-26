<?php
require_once __DIR__ . '/ConnectDB.php';
/**
 * Class that handles all Create operations for the Web-App.
 */
class CreateQuery extends ConnectDB {
  private $conn;

  public function __construct() {
    $this->conn = $this->getConn();
  }

  /**
   * Function to insert new users to the table.
   *
   * @param string $user_name
   *  User name for the new account.
   * @param string $email
   *  Email for the new account.
   * @param string|null $password
   *  Password set for the new account.
   * 
   * @return void
   */
  public function addUser(string $user_name, string $email, string|null $password) {
    $conn = $this->conn;
    if ($password != NULL) {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare('INSERT INTO Users (user_name, email, password) VALUES (:username, :email, :password);');
      $stmt->execute([
        'username' => $user_name, 
        'email' => $email,
        'password' => $password_hash,
      ]);
    }
    else {
      $stmt = $conn->prepare('INSERT INTO Users (user_name, email) VALUES (:username, :email);');
      $stmt->execute([
        'username' => $user_name, 
        'email' => $email
      ]);
    }
  }

  /**
   * Function to insert a new stock to the post database.
   *
   * @param integer $user_id
   *  User-id of the user.
   * @param string $content
   *  Text content of the post.
   * @param string $media
   *  Media content in the post.
   * @param string $media_type
   *  Media type of the media in the post.
   * 
   * @return void
   */
  public function addStock(int $user_id, string $stock_name, int $stock_price) {
    $conn = $this->conn;
    $time_created = $time_edited = date('Y-m-d H:i:s', time());
    $stmt = $conn->prepare('INSERT INTO Stocks (user_id, stock_name, stock_price, time_created, time_edited) VALUES (:user_id, :stock_name, :stock_price, :time_created, :time_edited);');
    $stmt->execute([
      'user_id' => $user_id,
      'stock_name' => $stock_name,
      'stock_price' => $stock_price,
      'time_created' => $time_created,
      'time_edited' => $time_edited,
    ]);
  }
}