<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/AppointmentsDao.class.php';

class AppointmentsService extends BaseService{

  public function __construct(){
    $this->dao = new AppointmentsDao();
  }

  public function get_appointments($search, $offset, $limit, $order){
    if($search){
      return $this->dao->get_appointments($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function add($appointment){
    if(!isset($account['name'])) throw new Exception("Name is missing!");

    return parent::add($appointment);
  }

  public function remove($appointment){

    $appointments = $this->dao->get_by_id($appointment['id']);

    $this->dao->update($appointment['id'], ['deleted' => 1]);

    return $appointments;
  }
}
?>
