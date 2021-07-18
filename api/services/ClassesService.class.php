<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/ClassesDao.class.php';

class ClassesService extends BaseService{

  public function __construct(){
    $this->dao = new ClassesDao();
  }

  public function get_classes($search, $offset, $limit, $order){
      return $this->dao->get_classes($search, $offset, $limit, $order);
  }

  public function add($classes){

    return parent::add($classes);
  }

  public function remove($class){

    $classes = $this->dao->get_by_id($class['id']);

    $this->dao->update($class['id'], ['deleted' => 1]);

    return $classes;
  }

  public function booked($class){

    $classes = $this->dao->get_by_id($class['id']);

    $this->dao->update($class['id'], ['booked' => 1]);

    return $classes;
  }

  public function get_classes_for_user($search, $offset, $limit, $order){
      return $this->dao->get_classes_for_user($search, $offset, $limit, $order);
  }

  public function get_classes_for_tutor($search, $offset, $limit, $order){
      return $this->dao->get_classes_for_tutor($search, $offset, $limit, $order);
  }

  public function get_classes_booked($search, $offset, $limit, $order){
      return $this->dao->get_classes_booked($search, $offset, $limit, $order);
  }

}
?>
