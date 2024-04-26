<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/LoadEnv.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
/**
 * Class to handle LinkedIn API(v2) requests and responses.
 */
class LinkedInAPIv2 {
  
  /**
   * Initial Redirect URL for user to Sign-in to LinkedIn and allow access.
   *
   * @var string
   */
  private $url;
  
  /**
   * Encrypted ID Token received from LinkedIn which has user info.
   *
   * @var string
   */
  private $id_token;
  
  /**
   * Error message generated during any process.
   *
   * @var string
   */
  private $err;

  /**
   * Constructor initialising the initial urls.
   */
  public function __construct() {
    LoadEnv::loadDotEnv();
    $client_id = $_ENV['CLIENT_ID'];
    $redirect = 'http://mod2test.com/';
    $scope = rawurlencode('openid email');
    $this->url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=$client_id&redirect_uri=$redirect&state=foobar&scope=$scope";
  }
  
  /**
   * Function to Redirect to LinkedIn Sign-in/Authorization for the user;
   *
   * @return void
   */
  public function authorize() {
    header("Location: $this->url");
  }

  /**
   * Function to get access token for the user from LinkedIn.
   *
   * @param string $code
   *  The code received as query string sent by LinkedIn callback.
   * 
   * @return void
   */
  public function getAccess($code) {
    $client = new Client();
    $access_url = 'https://www.linkedin.com/oauth/v2/accessToken';
    try {
      $response = $client->request('POST', $access_url, [
        'form_params' => [
          'grant_type' => 'authorization_code',
          'code' => $code,
          'client_id' => $_ENV['CLIENT_ID'],
          'client_secret' => $_ENV['CLIENT_SECRET'],
          'redirect_uri' => 'http://mod2test.com/'
        ]
      ]);
      $data = json_decode($response->getBody()->getContents(), true);
      $this->id_token = $data['id_token']; 
    }
    catch (RequestException $e){
      if ($e->hasResponse()) {
        $this->err = $e->getResponse()->getBody();
      }
      else {
        $this->err = $e->getMessage();
      }
    }
  }

  /**
   * Function to retrieve info about user.
   *
   * @return array
   *  Associative array containing decoded user info.
   */
  public function getInfo() {
    $id_token = $this->id_token;
    try {
      $decoded_token = explode('.', $id_token);
      $payload_encrypted = $decoded_token[1];
      $raw_decoded = base64_decode($payload_encrypted);
      $payload = json_decode($raw_decoded, true);
      return $payload;
    }
    catch (Exception $e){
      $this->err = $e->getMessage();
    }
  }

  /**
   * Function to return error messages.
   *
   * @return string
   */
  public function getError() {
    return $this->err;
  }
}
