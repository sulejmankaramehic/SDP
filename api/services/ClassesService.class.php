<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/ClassesDao.class.php';

class ClassesService extends BaseService{

  public function __construct(){
    $this->dao = new ClassesDao();
  }

  public function get_classes($offset, $limit, $order){
      return $this->dao->get_classes($offset, $limit, $order);
  }

  public function get_classesadmin($offset, $limit, $order){
      return $this->dao->get_classesadmin($offset, $limit, $order);
  }

  public function add($classes){

    if($classes['name'] == NULL) throw new Exception("Name field missing!", 400);
    if($classes['subject']== NULL) throw new Exception("Subject field missing!", 400);

    return parent::add($classes);
  }

  public function remove($class){

    $classes = $this->dao->get_by_id($class['id']);

    $this->dao->update($class['id'], ['deleted' => 1]);

    return $classes;
  }

  public function booked($class){

      $class = parent::update($class['id'],[
        "booked"=>$class['booked'],
        "bookedby"=>$class['bookedby']
      ]);
  }

  public function get_classes_for_user($offset, $limit, $order, $id){
      return $this->dao->get_classes_for_user($offset, $limit, $order, $id);
  }

  public function get_classes_for_tutor($offset, $limit, $order){
      return $this->dao->get_classes_for_tutor($offset, $limit, $order);
  }

  public function get_classes_for_tutorbooked($offset, $limit, $order, $id){
      return $this->dao->get_classes_for_tutorbooked($offset, $limit, $order, $id);
  }

  public function get_classes_booked($offset, $limit, $order){
      return $this->dao->get_classes_booked($offset, $limit, $order);
  }

  public function get_appo($offset, $limit, $order){
      return $this->dao->get_appo($offset, $limit, $order);
  }

  public function get_tutorappo($offset, $limit, $order){
      return $this->dao->get_tutorappo($offset, $limit, $order);
  }
}
?>
