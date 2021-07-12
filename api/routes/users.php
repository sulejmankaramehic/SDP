<?php
/**
 * @OA\Info(title="Online Tutor Platform API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(url="http://localhost/SDP/api/", description="Development Environment")),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication")
 */
/**
 * @OA\Post(path="/users/register", tags={"users"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *     				 @OA\Property(property="name", required="true", type="string", example="First Name",	description="Name of the user`" ),
 *     				 @OA\Property(property="last_name", required="true", type="string", example="Last Name",	description="Surname of the user`" ),
 *     				 @OA\Property(property="username", required="true", type="string", example="Username",	description="Username`" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->register($data);

  Flight::json(["mesaage" => "Activation link has been sent to your email!"]);
});

/**
 * @OA\Get(path="/users/confirm/{token}", tags={"users"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation")
 * )
 */
Flight::route('GET /users/confirm/@token', function($token){
  Flight::userService()->confirm($token);
  Flight::json(["message" => "Your account hass been activated"]);
});

/**
 * @OA\Post(path="/users/login", tags={"users"},
 *   @OA\RequestBody(description="User login", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been loged in.")
 * )
 */
Flight::route('POST /users/login', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->login($data));
});

/**
 * @OA\Post(path="/users/forgot", tags={"users"},
 *   @OA\RequestBody(description="Send recovery link", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that recovery link hass been sent")
 * )
 */
Flight::route('POST /users/forgot', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->forgot($data);
  Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/users/reset", tags={"users"},
 *   @OA\RequestBody(description="Reset user password using recovery token", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="token", required="true", type="string", example="123",	description="Token" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="12345",	description="New password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has changed password")
 * )
 */
Flight::route('POST /users/reset', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->reset($data);
  Flight::json(["message" => "Your password has been changed"]);
});

/**
 * @OA\Get(path="/users/{id}", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", default=1, description="ID of user"),
 *     @OA\Response(response="200", description="Fetching user based on ID")
 * )
 */
Flight::route('GET /users/@id', function($id){
  $headers = getallheaders();
  $token = @$headers['Authentication'];
  try {
    $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", ["HS256"]);
    if ($decoded['id'] == $id){
      Flight::json(Flight::userService()->get_by_id($id));
    }else{
      Flight::json(["message" => "This is not meant for you!"], 403);
    }
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
  }
});
?>
