<?php

require_once dirname(__FILE__)."/dao/UserDao.class.php";

$user_dao = new UserDao();

$user1 = [

  "name" => "Miki",
  "last_name" => "Maus",
  "email" => "miki@gmail.com",
  "username" => "miki",
  "password" => "123"
];

$user = $user_dao->add_user($user1);

//$user_dao -> get_user_by_id(11);

//get_user_by_username("test");

print_r($user);



?>
