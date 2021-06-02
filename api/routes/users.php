<?php

Flight::route('GET /users', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 10);
  $search = Flight::query('search');

  Flight::json(Flight::userService()->get_users($search, $offset, $limit));
});

Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});

Flight::route('POST /users', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->add($data));
});

Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::userService()->update($id, $data);
});
?>
