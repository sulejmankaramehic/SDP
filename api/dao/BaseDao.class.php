<?php

require_once dirname(__FILE__)."/../config.php";


class BaseDao {

  protected $connection;

  public function __construct($table){

    $this->table = $table;

    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        throw $e;
    }

  }

  protected function insert($table, $entity){

    $query ="INSERT INTO ${table} (";
    foreach ($entity as $column => $value){
      $query .= $column.", ";
    }
    $query = substr($query, 0 ,-2);
    $query .= ") VALUES (";
      foreach ($entity as $column => $value){
      $query .= ":".$column.", ";
      }
    $query = substr($query, 0, -2);
    $query .= ")";

    $stmt= $this->connection->prepare($query);
    $stmt->execute($entity);
    $user['id'] = $this->connection->lastInsertId();
    return $user;

  }

  protected function query($query, $params){

    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }

  protected function execute_update($table, $id, $entity, $id_cloumn = "id"){

    $query = "UPDATE ${table} SET ";
    foreach($entity as $name => $value){
      $query .= $name ."= :". $name. ", ";
    }

    $query = substr($query, 0 ,-2);
    $query .= " WHERE ${id_cloumn} = :id";

    $stmt= $this->connection->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);

  }

  protected function query_unique($query, $params){

    $result = $this -> query($query, $params);
    return reset($result);

  }

  public function add($entity){

    return $this->insert($this->table, $entity);

  }

  public function update($id, $entity){

    return $this->execute_update($this->table, $id, $entity);

  }

  public function get_by_id($id){

    return $this -> query_unique("SELECT * FROM ".$this->table." WHERE id = :id", ["id" => $id]);

  }

}

?>
