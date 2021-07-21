<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao{

  public function __construct(){

    parent::__construct("users");

  }

  public function get_user_by_username($username){
    return $this->query_unique("SELECT * FROM users WHERE username = :username", ["username" => $username]);
  }

  public function get_user_by_email($email){
    return $this->query_unique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
  }

  public function update_user_by_email($email, $user){
    $this->update("users", $email, $user, "email");
  }

  public function get_user_by_token($token){
    return $this->query_unique("SELECT * FROM users WHERE token = :token", ["token" => $token]);
  }

  public function get_users($offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT *
                         FROM users
                         WHERE deleted=0
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",[]);
  }

  public function get_usersedit($offset, $limit, $order, $id){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT *
                         FROM users
                         WHERE  id=${id}
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",[]);
  }

  public function get_tutoredit($offset, $limit, $order, $id){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT *
                         FROM users
                         WHERE  id=${id}
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",[]);
  }
}

?>
