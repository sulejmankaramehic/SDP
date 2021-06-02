<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/dao/UserDao.class.php';
require_once dirname(__FILE__).'/services/UserService.class.php';

/* Utility function for reading query parameters from URL*/
Flight::map('query', function($name, $default_value = NULL){
  $request = Flight::request();
  $query_parameters = @$request->query->getData()[$name];
  $query_parameters = $query_parameters ? $query_parameters : $default_value;
  return $query_parameters;
});

/* Registering DAO layer*/
Flight::register('userDao','UserDao');

/* Registering Business logic layer services*/
Flight::register('userService','UserService');

/* Including all routes*/
require_once dirname(__FILE__).'/routes/users.php';



Flight::start();

?>
