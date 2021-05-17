<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao{

  public function get_user_by_username($username){

    return $this->query_unique("SELECT * FROM users WHERE username = :username", ["username" => $username]);

  }

  public function get_user_by_id($id){

    return $this -> query_unique("SELECT * FROM users WHERE id = :id", ["id" => $id]);

  }

  public function add_user($user){

    $sql = "INSERT INTO users (name, last_name, email, username, password) VALUES (:name, :last_name, :email, :username, :password)";
    $stmt= $this->connection->prepare($sql);
    $stmt->execute($user);
    $user['id'] = $this -> connection -> lastInsertId();
    return $user;

  }

  public function update_user($id, $user){


  }
}

?>
