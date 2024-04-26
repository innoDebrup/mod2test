<?php
require_once __DIR__.'/ConnectDB.php';
/**
 * Class that handles all Create operations for the Web-App.
 */
class ReadQuery extends ConnectDB {
  private $conn;
  /**
   * Constructor to set connected database object.
   */
  public function __construct() {
    $this->conn = $this->getConn();
  }

  /**
   * Function to get the Token of an account.
   *
   * @param string $email
   *  Email of the account from which the token is to be read.
   * 
   * @return mixed
   *  An array containing the reset_token and the token_timer.
   */
  public function getToken(string $email) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT reset_token, token_timer FROM Users WHERE email=:email;");
    $stmt->execute([
      'email' => $email
    ]);
    $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_array;
  }

  /**
   * Function to check if the Token is present in the table.
   *
   * @param string $token
   *  Entered token which needs verification.
   * 
   * @return mixed
   *  An array containing the user_id and the token-timer.
   */
  public function checkToken(string $token) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT user_id, token_timer FROM Users WHERE reset_token = :token;");
    $stmt->execute([
      'token' => $token
    ]);
    $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_array;
  }

  /**
   * Function to check if the user exists or not.
   *
   * @param string $user_name
   *  Username to be searched for.
   * @param string $email
   *  Email to be searched for.
   * 
   * @return bool
   *  Returns FALSE if User/Email is present or TRUE if none are present.  
   */
  public function checkUser(string $user_name, string $email) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name = :username OR email = :email;");
    $stmt->execute([
      'username' => $user_name,
      'email' => $email
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result)) {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  /**
   * Function to check if Email is present in the table or not.
   *
   * @param string $email
   *  Email which is to be searched for.
   * 
   * @return bool
   *  Returns TRUE if Email is present or FALSE if Email is not present.
   */
  public function checkEmail(string $email){
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :email ;");
    $stmt->execute([
      'email' => $email
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Function to get the password of a given account.
   *
   * @param string $user_mail
   *  Email of the account whose password needs to be fetched.
   * 
   * @return string
   *  Returns the password(hash) in string format.
   */
  public function getPass(string $user_mail) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name = :user_mail OR email = :user_mail;");
    $stmt->execute([
      'user_mail' => $user_mail
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $password = $result['password'];
    return $password;
  }
  /**
   * Function to get the user_id of a given account.
   *
   * @param string $user_mail
   *  Email of the account whose password needs to be fetched.
   * 
   * @return string
   *  Returns the user_id in string format.
   */
  public function getID(string $user_mail) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name = :user_mail OR email = :user_mail;");
    $stmt->execute([
      'user_mail' => $user_mail
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $result['user_id'];
    return $user_id;
  }
  /**
   * Function to get the stocks.
   * 
   * @return mixed
   *  Returns associative array or FALSE incase of failure.
   */
  public function getStocks() {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT s_id, s.user_id, u.user_name, stock_name, stock_price, time_created, time_edited  FROM Stocks s JOIN Users u ON s.user_id = u.user_id;");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
