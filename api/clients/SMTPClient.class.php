<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';
require_once dirname(__FILE__).'/../config.php';


class SMTPClient {

  private $mailer;

  public function __construct(){

    // Create the Transport
    $transport = (new Swift_SmtpTransport(Config::SMTP_HOST(), Config::SMTP_PORT(), 'tls'))
      ->setUsername(Config::SMTP_USERNAME())
      ->setPassword(Config::SMTP_PASSWORD());

    // Create the Mailer using your created Transport
    $this->mailer = new Swift_Mailer($transport);

  }

  public function send_token($user){

    // Create a message
    $message = (new Swift_Message('Confirmation link'))
      ->setFrom(['mail.responder2021@gmail.com' => 'Online Tutor Platform'])
      ->setTo([$user['email']])
      ->setBody('Please verify your account on the following link: https://onlinetutoring.sknet.me/api/confirm/'.$user['token']);

    // Send the message
    $this->mailer->send($message);
  }

  public function send_recovery_token($user){

    // Create a message
    $message = (new Swift_Message('Recovery token'))
      ->setFrom(['mail.responder2021@gmail.com' => 'Online Tutor Platform'])
      ->setTo([$user['email']])
      ->setBody('Here is the token that you need to be able to change your password: '.$user['token']);

    // Send the message
    $this->mailer->send($message);
  }
}

?>
