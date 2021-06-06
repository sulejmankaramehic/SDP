<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';
require_once dirname(__FILE__).'/../dao/AccountDao.class.php';

class UserService extends BaseService{

  private $accountDao;

  public function __construct(){
    $this->dao = new UserDao();
    $this->accountDao = new AccountDao();
  }

  public function register($user){
    if (!isset($user['account'])) throw new Exception("Account field is required");

    try {
      $this->dao->beginTransaction();
      $account = $this->accountDao->add([
        "name"=> $user['account'],
        "status"=>"PENDING"
      ]);

      $user = parent::add([
        "acc_id"=>$account['id'],
        "name"=>$user['name'],
        "last_name"=>$user['last_name'],
        "username"=>$user['username'],
        "password"=>$user['password'],
        "email"=>$user['email'],
        "role"=>"BASIC_USER",
        "status"=>"PENDING",
        "token"=> md5(random_bytes(16))
      ]);
      $this->dao->commit();

    } catch (\Exception $e) {
      $this->dao->rollBack();
      throw $e;
    }

    //send email with token

    return $user;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if(!isset($user['id'])) throw Exception("Inavlid token");
    $this->dao->update($user['id'], ["status" => "ACTIVE"]);
    $this->accountDao->update($user['acc_id'], ["status" => "ACTIVE"]);

    //TODO send email

  }
}
?>
