<?php
/**
 * @OA\Get(path="/admin/accounts", tags={"x-admin","account"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements"),
 *     @OA\Response(response="200", description="List accounts from databse")
 * )
 */
Flight::route('GET /classes', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::classesService()->get_classes($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/admin/accounts/{id}", tags={"x-admin", "account"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", default=1, description="ID of account"),
 *     @OA\Response(response="200", description="Fetching account based on ID")
 * )
 */
Flight::route('GET /admin/accounts/@id', function($id){
  if(Flight::get('user')['aid'] != $id) throw new Exception("This information is not for you", 403);
  Flight::json(Flight::accountService()->get_by_id($id));
});

/**
 * @OA\Post(path="/admin/accounts", tags={"x-admin", "account"}, security={{"ApiKeyAuth": {}}},
*   @OA\RequestBody(description="Account info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				 @OA\Property(property="name", required="true", type="string", example="Test",	description="Name of the account" ),
*    				 @OA\Property(property="status", type="string", example="ACTIVE",	description="Account status" )
*          )
*       )
*     ),
 *     @OA\Response(response="200", description="Add account")
 * )
 */
Flight::route('POST /classes', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::classesService()->add($data));
});

/**
 * @OA\Put(path="/admin/accounts/{id}", tags={"x-admin", "account"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *     @OA\RequestBody(description="Account info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="Test",	description="Name of the account" ),
 *    				 @OA\Property(property="status", type="string", example="ACTIVE",	description="Account status" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update account based on ID")
 * )
 */
Flight::route('PUT /admin/accounts/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::accountService()->update($id, $data);
});

/**
 * @OA\Get(path="/user/accounts", tags={"x-user", "account"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Response(response="200", description="Fetch user account")
 * )
 */
Flight::route('GET /user/account', function(){
  Flight::json(Flight::accountService()->get_by_id(Flight::get('user')['aid']));
});

Flight::route('POST /classes/remove', function(){
  Flight::json(Flight::classesService()->remove(Flight::request()->data->getData()));
});

Flight::route('POST /classes/book', function(){
  Flight::json(Flight::classesService()->booked(Flight::request()->data->getData()));
});

Flight::route('POST /classes/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::classesService()->update($id, $data);
});

Flight::route('GET /classes/@id', function($id){
  Flight::json(Flight::classesService()->get_by_id($id));
});

Flight::route('GET /classesuser', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::classesService()->get_classes_for_user($search, $offset, $limit, $order));
});

Flight::route('POST /classes/unbook', function(){
  Flight::json(Flight::classesService()->unbooked(Flight::request()->data->getData()));
});

Flight::route('GET /classestutor', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::classesService()->get_classes_for_tutor($search, $offset, $limit, $order));
});

Flight::route('GET /classesbooked', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::classesService()->get_classes_booked($search, $offset, $limit, $order));
});

?>
