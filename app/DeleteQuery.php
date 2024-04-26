<?php
require_once __DIR__.'/ConnectDB.php';

/**
 * Class to handle all delete queries.
 */
class DeleteQuery extends ConnectDB{
  /**
   * Variable to store connected database object.
   *
   * @var \PDO
   */
  private $conn;
  
  /**
   * Constructor to set the conn variable.
   */
  public function __construct() {
    $this->conn = $this->getConn();
  }

  /**
   * Function to remove Stock from Stocks database.
   *
   * @param int $s_id
   *  Post_id of the stock.
   * @param int $user_id
   *  User_id of the user.
   * 
   * @return void
   */
  public function removeStock(int $user_id, int $s_id) {
    $conn = $this->conn;
    $stmt = $conn->prepare('DELETE FROM Stocks WHERE s_id = :s_id AND user_id = :user_id;');
    $stmt->execute([
      's_id' => $s_id,
      'user_id' => $user_id
    ]);
  }
}
