<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AppointmentsDao extends BaseDao{

  public function __construct(){

    parent::__construct("classes");

  }

  public function get_appointments($search, $offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT a.name,a.time,b.name
                         FROM classes as a, classes as b
                         WHERE LOWER(name) LIKE CONCAT('%', :name, '%') and deleted=0 and a.id=b.id
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }
}
?>
