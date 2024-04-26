<?php
require_once __DIR__ . '/LoadEnv.php';

/**
 * Database Class to connect to the MySQL server and insert data in to the database.
 */
class ConnectDB {
  
  /**
   * Stores the connected database object provided by mysqli.
   * @var \PDO
   */
  private $conn;

  /**
   * Connect to Database and show database.
   *
   * @return \PDO
   */
  public function getConn() {
    LoadEnv::loadDotEnv();
    $server_name = $_ENV['S_NAME'];
    $user_name = $_ENV['U_NAME'];
    $password = $_ENV['PWD'];
    $database = $_ENV['DB_NAME'];
    $database_server = "mysql:host=$server_name;dbname=$database";
    try {
      $this->conn = new PDO($database_server, $user_name, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
    return $this->conn;
  }

  /**
   * Function to close connection.
   *
   * @return void
   */
  public function closeConnection() {
    unset($this->conn);
  }

}
