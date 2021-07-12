<?php

Flight::before('start', function(&$params, &$output){

  if(Flight::request()->url == '/swagger') return TRUE;

  if(substr(Flight::request()->url,0,7) === '/users/') return TRUE;

  $headers = getallheaders();
  $token = @$headers['Authentication'];
  try {
    $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", ["HS256"]);
    FLight::set('user', $decoded);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

?>
