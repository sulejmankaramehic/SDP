<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/services/UserService.class.php';
require_once dirname(__FILE__).'/services/AccountService.class.php';

// Flight::set('flight.log_errors', true);
//
// /*error handeling for our api*/
// Flight::map('error', function(Exception $ex){
//   Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
// });

/* Utility function for reading query parameters from URL*/
Flight::map('query', function($name, $default_value = NULL){
  $request = Flight::request();
  $query_parameters = @$request->query->getData()[$name];
  $query_parameters = $query_parameters ? $query_parameters : $default_value;
  return $query_parameters;
});

/* Registering Business logic layer services*/
Flight::register('userService','UserService');
Flight::register('accountService','AccountService');


/* Including all routes*/
require_once dirname(__FILE__).'/routes/users.php';
require_once dirname(__FILE__).'/routes/accounts.php';
require_once dirname(__FILE__).'/routes/middleware.php';

/*Swagger documentacion*/
Flight::route('GET /swagger', function(){
  $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

Flight::route('GET /', function(){
  Flight::redirect('/docs');
});

Flight::start();

?>
