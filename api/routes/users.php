<?php

/**
 * @OA\Post(path="/users/register", tags={"Register"},
 * @OA\RequestBody(
    * description="Main user info",
    * required=true,
        * @OA\MediaType(mediaType="application/json",
            * @OA\Schema(
                * @OA\Property(property="email", type="string", example="", description="Type in email"),
                * @OA\Property(property="password", type="string", example="", description="Type in password"),
                * @OA\Property(property="first_name", type="string", example="", description="Type in name"),
                * @OA\Property(property="username", type="string", example="", description="Type in username"),
                * @OA\Property(property="last_name", type="string", example="", description="Type in surname") ) ) ),
 * @OA\Response(response="200", description="Register")
 * )
 *
 */
Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->register($data));
});

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userService()->confirm($token);
  Flight::json(["message" => "Your account hass been activated"]);
});

?>
