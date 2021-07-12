<?php

Flight::route('/user/*', function(){

    try {
      $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
      if(Flight::request()->method != "GET" && $user["role"] == "USER_READ_ONLY"){
        throw new Exception("Read only user is not able to make changes", 403);
      }
      Flight::set('user', $user);
      return TRUE;
    } catch (\Exception $e) {
      Flight::json(["message" => $e->getMessage()], 401);
      die;
    }
});

Flight::route('/admin/*', function(){

    try {
      $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
      if($user['role'] != "ADMIN"){
        throw new Exception("Admin access required!", 403);
      }
      Flight::set('user', $user);
      return TRUE;
    } catch (\Exception $e) {
      Flight::json(["message" => $e->getMessage()], 401);
      die;
    }
});
?>
