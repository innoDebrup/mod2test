<?php
require_once '/vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv::createImmutable('/var/www/mvc/app/core/');
$dotenv->load();
/**
 * Class for generating and sending OTP.
 */
class OTP {
  /**
   * Variable to store Email error message.
   *
   * @var string
   */
  public $emailError;
  /**
   * Function to generate and send OTP to mail.
   *
   * @param string $email
   *  Email to send the OTP to.
   * 
   * @return int
   *  Return the OTP generated.
   */
  public function sendOTP(string $email ,string $otp) {
    $mail = new PHPMailer(TRUE);
    $mail->isSMTP();
    // Setting the sender mail configuration.
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = TRUE;
    // Accessing key values from .env file.
    $mail->Username = $_ENV['USER_NAME'];
    $mail->Password = $_ENV['PASSWORD'];
    // SMTP port.
    $mail->Port = 465;
    // Standard TLS encryption.
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    // Setting Mail content type and sender info.
    $mail->isHTML(TRUE);
    $mail->setFrom($mail->Username);
    $mail->addAddress($email);
    $mail->Subject = ("OTP for Email Verification !!");
      $mail->Body = "<h1>Thank you for Registering! </h1> <h3>This is the last step for completing your Registration.</h3> <p>Use this OTP to verify your email on our website:</p> <h3>$otp</h3>";
    $mail->send(); 
  }
  /**
   * Generate OTP for sending through email.
   *
   * @return string
   *  Return the generated OTP in string format.
   */
  public function genOTP() {
    $otp = rand(1000, 9999);
    return (string)$otp;
  }
  /**
   * Validate email if it is acceptable or not.
   *
   * @param string $email
   *  Email address received as per user-input.
   * 
   * @return void
   */
  public function validateMail(string $email) {
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $this->emailError = 'Invalid Email address format!';
      return FALSE;
    }
    // $client = new Client();
    // $access_key = $_ENV['ACCESS_KEY'];
    // $response = $client->request('GET', 'https://emailvalidation.abstractapi.com/v1/?api_key=' . $access_key . '&email=' . $email);
    // // Stores the response received in the form of an array.
    // $data = json_decode($response->getBody(), TRUE);
    // if ($data["is_disposable_email"]["value"]) {
    //   $this->emailError = 'Cannot use temporary Email address!';
    //   return FALSE;
    // } 
    // elseif ($data['deliverability'] === 'UNDELIVERABLE') {
    //   $this->emailError = 'Email address does not exists!';
    //   return FALSE;
    // } 
    // else {
      return TRUE;
    // }
  }
  /**
   * Function to check if the email is already present in the database or not.
   *
   * @param string $email
   *  Email received as user-input.
   * @return  bool
   *  TRUE if email exists or FALSE if email does not exists in the table.
   */
  public function checkDuplicate (string $email) {
    require '../../model/QueryCall.php';
    return $read->checkEmail($email);
  }  
}
