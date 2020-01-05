<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use App\Http\Resources\Api\UserResource;
use App\User;
use Input;
use Validator;
use Auth;
use DB;

class AuthController extends CController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public $user;
    
    public function login(Request $request)
    {     
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password'  => 'required'
        ]);
        
        if ($validator->fails()) {    
            return $this->validateError($validator->errors());
        } 

        if (!$token = Auth::attempt(['email' => $request['username'], 'password' => $request['password']])) {
            return $this->commonError('Invalid username or password');
        }

        $userId = Auth::id();
        $model = User::where('id', $userId)->first();
        $model->api_token = $token;
        $data = new UserResource($model);
        return $this->asJson($data);
    }
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="darius@matulionis.lt"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
/**
 * @OA\Tag(
 *     name="project",
 *     description="Everything about your Projects",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 *
 * @OA\Tag(
 *     name="user",
 *     description="Operations about user",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 * @OA\ExternalDocumentation(
 *     description="Find out more about Swagger",
 *     url="http://swagger.io"
 * )
 */
      /**
     * @OA\Post(
     *     path="/api/test",
     *     tags={"pet"},
     *     summary="Deletes a pet",
     *     operationId="deletePet",
     *     @OA\Parameter(
     *         name="petId",
     *         in="cookie",
     *         description="Pet id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pet not found",
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     * )
     */
    public function test(){
        print_r($_POST);
        return;
    }
}
