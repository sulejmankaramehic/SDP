<?php
/**
 * @OA\Get(path="/accounts", tags={"account"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements"),
 *     @OA\Response(response="200", description="List accounts from databse")
 * )
 */
Flight::route('GET /accounts', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/accounts/{id}", tags={"account"},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", default=1, description="ID of account"),
 *     @OA\Response(response="200", description="Fetching account based on ID")
 * )
 */
Flight::route('GET /accounts/@id', function($id){
  Flight::json(Flight::accountService()->get_by_id($id));
});

/**
 * @OA\Post(path="/accounts", tags={"account"},
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
Flight::route('POST /accounts', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::accountService()->add($data));
});

/**
 * @OA\Put(path="/accounts/{id}", tags={"account"},
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
Flight::route('PUT /accounts/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::accountService()->update($id, $data);
});
?>
