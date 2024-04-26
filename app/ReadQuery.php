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
   * Retrieves the user_id of the user for further processing.
   *
   * @param string $usermail
   *  Username or Email of the user.
   * 
   * @return mixed
   */
  public function getUserInfo(string $usermail) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT user_id, user_name, email FROM Users WHERE user_name = :usermail OR email = :usermail;");
    $stmt->execute([
      'usermail' => $usermail
    ]);
    $result_arr = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_arr;
  }

  /**
   * Function to retrieve User Details of the given user.
   *
   * @param int $user_id
   *  User_ID of the required user.
   * 
   * @return mixed
   */
  public function getUserDetails(int $user_id) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT * FROM UserDetails WHERE user_id = :userid ;");
    $stmt->execute([
      'userid' => $user_id
    ]);
    $result_arr = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_arr;
  }

  /**
   * Function to get the post contents.
   *
   * @param integer $limit
   *  Limit to set the max no. of rows to show.
   * @param integer $offset
   *  Initial offset to start the selection.
   * 
   * @return array
   */
  public function getPosts(int $limit, int $offset) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT 
        u.user_name, 
        profile_pic, 
        post_id, 
        content, 
        media,
        media_type, 
        likes,
        time 
      FROM 
        Posts p 
      JOIN 
        Users u 
      ON 
        p.user_id = u.user_id 
      JOIN
        UserDetails ud
      ON
        u.user_id = ud.user_id 
      ORDER BY 
        time
      DESC 
      LIMIT 
        $limit
      OFFSET 
        $offset ;");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * Function to obtain the total no. of likes of a post.
   *
   * @param int $post_id
   *  The post_id of the post.
   * 
   * @return int
   *  Total no. of likes are returned.
   */
  public function getTotalLikes(int $post_id) {
    $conn = $this->conn;
    $stmt = $conn->prepare('SELECT likes FROM Posts WHERE post_id = :post_id;');
    $stmt->execute([
      'post_id' => $post_id
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['likes'];
  }

  /**
   * Function to checked which posts a user has liked.
   *
   * @param integer $user_id
   *  User_id of the user.
   * 
   * @return array|false
   *  Returns array of rows selected OR FALSE if no suitable rows are present.
   */
  public function Liked(int $user_id) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT post_id FROM Likes WHERE user_id = :user_id;");
    $stmt->execute([
      'user_id'=>$user_id
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * Function to get all the comments of a post.
   *
   * @param integer $post_id
   *  Post_id of the post whose comments are to be loaded.
   * 
   * @return array
   */
  public function getComments(int $post_id) {
    $conn = $this->conn;
    $stmt = $conn->prepare("SELECT 
        u.user_name, 
        profile_pic, 
        post_id, 
        comment
      FROM 
        Comments c 
      JOIN 
        Users u 
      ON 
        c.user_id = u.user_id 
      JOIN
        UserDetails ud
      ON
        u.user_id = ud.user_id 
      WHERE 
        c.post_id = :post_id
      ORDER BY
        c_id
      DESC;
    ");
    $stmt->execute([
      'post_id'=>$post_id
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * Function to obtain the total no. of comments on a post.
   *
   * @param int $post_id
   *  The post_id of the post.
   * 
   * @return int
   *  Total no. of comments are returned.
   */
  public function getTotalComments(int $post_id) {
    $conn = $this->conn;
    $stmt = $conn->prepare('SELECT COUNT(*) AS total_comments FROM Comments WHERE post_id = :post_id;');
    $stmt->execute([
      'post_id' => $post_id
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_comments'];
  }
}
