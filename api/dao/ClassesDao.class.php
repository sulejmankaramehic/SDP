<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ClassesDao extends BaseDao{

  public function __construct(){

    parent::__construct("classes");

  }

  public function get_classes($offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT *
                         FROM classes
                         WHERE booked=0 and deleted=0
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",[]);
  }

  public function get_classesadmin($offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.name,c.subject,c.duration,c.type,c.date, u.name AS tutorid
                          FROM classes c
                          INNER JOIN users u ON u.id=c.tutorid
                          WHERE c.deleted=0 AND c.booked=0
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}", []);
  }

  public function get_classes_for_tutor($search, $offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.subject,c.booked,c.name,c.duration,c.type,c.date,u.name as user
                         FROM classes c
                         INNER JOIN users u ON u.id=c.tutorid
                         WHERE c.deleted=0 AND c.booked=0
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }

  public function get_classes_for_user($search, $offset, $limit, $order, $id){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.subject,c.booked,c.name,c.duration,c.type,c.date
                         FROM classes c
                         INNER JOIN users u ON u.id=c.bookedby
                         WHERE c.deleted=0 AND c.booked=1 and u.id=${id}
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }

  public function get_classes_for_tutorbooked($search, $offset, $limit, $order, $id){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.subject,c.booked,c.name,c.duration,c.type,c.date
                         FROM classes c
                         INNER JOIN users u ON u.id=c.tutorid
                         WHERE c.deleted=0 AND c.booked=1 and u.id=${id}
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }

  public function get_classes_booked($search, $offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.booked,c.name,c.duration,c.type,c.date,u.name as student
                         FROM classes c
                         INNER JOIN users u ON u.id=c.bookedby
                         WHERE c.deleted=0 AND c.booked=1
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }

  public function get_appo($search, $offset, $limit, $order){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.name AS Subjcet, u.name AS tutor, l.name AS student
                          FROM classes c
                          INNER JOIN users u ON c.tutorid=u.id
                          INNER JOIN users l ON c.bookedby=l.id
                         WHERE c.deleted=0 AND c.booked=1
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }

  public function get_tutorappo($search, $offset, $limit, $order, $id){

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT c.id,c.name AS Subjcet, u.name AS tutor, l.name AS student, c.date, c.type, c.duration, u.id
                          FROM classes c
                          INNER JOIN users u ON c.tutorid=u.id
                          INNER JOIN users l ON c.bookedby=l.id
                         WHERE c.deleted=0 AND c.booked=1 and u.id=${id}
                         ORDER BY c.${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }
}
?>
