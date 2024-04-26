<?php
require_once __DIR__ . '/ConnectDB.php';
/**
 * Class that handles all Create operations for the Web-App.
 */
class UpdateQuery extends ConnectDB {
  private $conn;

  public function __construct() {
    $this->conn = $this->getConn();
  }

  /**
   * Function to add Token for Resetting password.
   *
   * @param string $email
   *  Email of the account whose Password is to be reset and Token generated.
   * 
   * @return void
   */
  public function addToken(string $email) {
    $conn = $this->conn;
    $token = bin2hex(random_bytes(16));
    $token_hash = hash('sha256',$token);
    $expiry = date('Y-m-d H:i:s', time() + 60 * 2);
    $stmt = $conn->prepare("UPDATE Users SET reset_token = :token, token_timer = :timer WHERE email = :email;");
    $stmt->execute([
      'token' => $token_hash,
      'timer' => $expiry,
      'email' => $email
    ]);
  }

  /**
   * Function to reset password.
   *
   * @param integer $user_id
   *  User-id of the account whose password is to be reset.
   * @param string $password
   *  New Password for the account.
   * 
   * @return void
   */
  public function resetPass(int $user_id, string $password) {
    $conn = $this->conn;
    $stmt = $conn->prepare("UPDATE Users SET password = :password, reset_token = NULL, token_timer = NULL WHERE user_id = :user_id;");
    $stmt->execute([
      'password' => $password,
      'user_id' => $user_id
    ]);
  }
}
