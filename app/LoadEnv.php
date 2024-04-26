<?php
require __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
/**
 * Class to handle .env file contents.
 */
class LoadEnv {
  /**
   * Function to load .env file key value pairs into $_ENV super global.
   *
   * @return void
   */
  public static function loadDotEnv() {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }
}
