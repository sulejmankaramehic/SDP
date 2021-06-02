<?php

require_once dirname(__FILE__)."/dao/UserDao.class.php";

$dao = new UserDao();

// $user = [
//   "name"=>"Nikola",
//   "last_name"=>"Milutinov",
//   "username"=>"Mile1",
//   "email"=>"mil2e@gmail.com",
//   "password"=>"1223"
// ];

$dao->update(1,[
  "name"=>"Milan"
]);

$user = $dao->get_all();

print_r($user);
?>
