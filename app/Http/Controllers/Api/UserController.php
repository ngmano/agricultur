<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CController;
use Auth;
use DB;
use Validator;
use App\User;

class UserController extends CController
{
    public function store()
    {   
        $validator = Validator::make(
                request()->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:6'   
                ]
            );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }    

        $model = new User();
        $model->fill(request()->all());
        $model->setPassword(request()->post('password'));
        $model->save();
        
        $this->setMessage('User Created Successfully');
        return $this->asJson();
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        $this->setMessage('Successfully logged out');
        return $this->asJson();
    }
}
