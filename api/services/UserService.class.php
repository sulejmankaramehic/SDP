<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

require_once dirname(__FILE__).'/../clients/SMTPClient.class.php';

class UserService extends BaseService{

  private $smtpClient;

  public function __construct(){
    $this->dao = new UserDao();
    $this->smtpClient = new SMTPClient();
  }

  public function login($user){

    $db_user = $this->dao->get_user_by_email($user['email']);

    if(!isset($db_user['id'])) throw new Exception("User not found", 400);

    if($db_user['deleted'] == 1) throw new Exception("User has been removed!", 400);

    if($db_user['status'] != 'ACTIVE') throw new Exception("User not active", 400);

    if($db_user['password'] != md5($user['password'])) throw new Exception("Invalid password!", 400);

    return $db_user;
  }

  public function register($user){
    try {
      $user = parent::add([
        "name"=>$user['name'],
        "last_name"=>$user['last_name'],
        "username"=>$user['username'],
        "password"=>md5($user['password']),
        "email"=>$user['email'],
        "role"=>$user['role'],
        "status"=>"PENDING",
        "token"=> md5(random_bytes(16))
      ]);
    } catch (Exception $e) {
      $this->dao->rollBack();
      if (strpos($e->getMessage(), 'comply with RFC 2822, 3.6.2.')) {
       throw new Exception("Please enter email in correct format", 400, $e);
     }else{
       throw $e;
     }
    }

    $this->smtpClient->send_token($user);

    return $user;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if(!isset($user['id'])) throw new Exception("Invalid token", 400);
    $this->dao->update($user['id'], ["status" => "ACTIVE", "token" => NULL]);

    return $user;
  }

  public function forgot($user){
    $db_user = $this->dao->get_user_by_email($user['email']);

    if (!isset($db_user['id'])) throw new Exception("User doesn't exists", 400);

    if (strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user['token_created_time']) < 300) throw new Exception("Be patient tokens is on his way", 400);

    $db_user = $this->update($db_user['id'], ['token' => md5(random_bytes(16)), 'token_created_time' => date(Config::DATE_FORMAT)]);

    $this->smtpClient->send_recovery_token($db_user);
  }

  public function reset($user){

    $db_user = $this->dao->get_user_by_token($user['token']);

    if(!isset($db_user['id'])) throw new Exception("Invalid token", 400);

    if(strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user['token_created_time']) > 600) throw new Exception("Token expired", 400);

    $this->dao->update($db_user['id'], ['password' => md5($user['password']), 'token' => NULL]);

    return $db_user;
  }

  public function remove($user){

    $db_user = $this->dao->get_by_id($user['id']);

    $this->dao->update($db_user['id'], ['deleted' => 1, 'email' => NULL]);

    return $db_user;
  }

  public function get_users($search, $offset, $limit, $order){
    if($search){
      return $this->dao->get_users($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function get_usersedit($search, $offset, $limit, $order, $id){
      return $this->dao->get_usersedit($search, $offset, $limit, $order, $id);
  }

  public function get_tutoredit($search, $offset, $limit, $order, $id){
      return $this->dao->get_tutoredit($search, $offset, $limit, $order, $id);
  }
}
?>
