<?php

require_once dirname(__FILE__)."/dao/UserDao.class.php";

$user_dao = new UserDao();




$user = $user_dao->get_by_id(9);

//$user_dao -> get_user_by_id(11);

//get_user_by_username("test");

print_r($user);



?>
