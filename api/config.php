<?php

class Config {

  public static function DB_HOST(){
    return Config::get_env("DB_HOST", "remotemysql.com");
  }
  public static function DB_USERNAME(){
    return Config::get_env("DB_USERNAME", "Imu43NxB5A");
  }
  public static function DB_PASSWORD(){
    return Config::get_env("DB_PASSWORD", "3bxrjQhU6i");
  }
  public static function DB_SCHEME(){
    return Config::get_env("DB_SCHEME", "Imu43NxB5A");
  }
  public static function DB_PORT(){
    return Config::get_env("DB_PORT", "3306");
  }
  public static function SMTP_HOST(){
    return Config::get_env("SMTP_HOST", "smtp.gmail.com");
  }
  public static function SMTP_PORT(){
    return Config::get_env("SMTP_PORT", "587");
  }
  public static function SMTP_USERNAME(){
    return Config::get_env("SMTP_USERNAME", "mail.responder2021@gmail.com");
  }
  public static function SMTP_PASSWORD(){
    return Config::get_env("SMTP_PASSWORD", "");
  }

  const DATE_FORMAT = "Y-m-d H:i:s";

  const JWT_SECRET = "jmc+TZu3J[7Fg~#&";
  const JWT_TIME = 604800;

  public static function get_env($name, $default){
  return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
  }
}

?>
