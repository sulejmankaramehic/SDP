<?php
/**
 * @OA\Info(title="Online Tutor Platform API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(url="http://localhost/SDP/api/", description="Development Environment"),
 *   @OA\Server(url="https://onlinetutoring.sknet.me/api/", description="Production Environment" )),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication")
 */
/**
 * @OA\Post(path="/register", tags={"login"},
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
Flight::route('POST /register', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->register($data);

  Flight::json(["mesaage" => "Activation link has been sent to your email!"]);
});

/**
 * @OA\Get(path="/confirm/{token}", tags={"login"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation")
 * )
 */
Flight::route('GET /confirm/@token', function($token){
  Flight::jwt(Flight::userService()->confirm($token));
  Flight::redirect('https://onlinetutoring.sknet.me/confirmation.html');
});

/**
 * @OA\Post(path="/login", tags={"login"},
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
Flight::route('POST /login', function(){
  Flight::json(Flight::jwt(Flight::userService()->login(Flight::request()->data->getData())));
});

/**
 * @OA\Post(path="/forgot", tags={"login"},
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
Flight::route('POST /forgot', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->forgot($data);
  Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/reset", tags={"login"},
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
Flight::route('POST /reset', function(){
  Flight::json(Flight::jwt(Flight::userService()->reset(Flight::request()->data->getData())));
});

/**
 * @OA\Get(path="/user/users", tags={"x-user", "users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Response(response="200", description="Fetch user account")
 * )
 */
Flight::route('GET /user/users', function(){
  Flight::json(Flight::userService()->get_by_id(Flight::get('user')['id']));
});

Flight::route('GET /users', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $order = Flight::query('order', "-id");
  Flight::json(Flight::userService()->get_users($offset, $limit, $order));
});

Flight::route('POST /remove', function(){
  Flight::json(Flight::jwt(Flight::userService()->remove(Flight::request()->data->getData())));
});

Flight::route('POST /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::userService()->update($id, $data);
});

Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});

Flight::route('GET /usersedit/@id', function($id){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $order = Flight::query('order', "-id");
  Flight::json(Flight::userService()->get_usersedit($offset, $limit, $order, $id));
});

Flight::route('GET /tutoredit/@id', function($id){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $order = Flight::query('order', "-id");
  Flight::json(Flight::userService()->get_tutoredit($offset, $limit, $order, $id));
});


?>
