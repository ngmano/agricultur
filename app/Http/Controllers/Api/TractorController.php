<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CController;
use Auth;
use Validator;
use App\{
    Tractor,
    User
};
use App\Http\Resources\Api\TractorResource;
use Illuminate\Validation\Rule;

class TractorController extends CController
{
    public function index()
    {
        $model = Tractor::get();
        $data = TractorResource::collection($model);

        $this->setMessage('Tractor List');
        return $this->asJson($data);
    }

    public function store()
    {   
        $validator = Validator::make(
                request()->all(),
                [
                    'tractor_name' => 'required|unique:tractors,tractor_name'
                ]
            );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }    

        $model = new Tractor();
        $model->fill(request()->all());
        $model->save();
        
        $this->setMessage('Tractor Created Successfully');
        return $this->asJson();
    }

    public function show($id)
    {
        $model = Tractor::instance()->findByKey($id);
        if ($model === null) {
            return $this->commonError('Invalid Data');
        }
        $data = new TractorResource($model);

        $this->setMessage('Tractor View');
        return $this->asJson($data);
    }

    public function update($id)
    {
        $model = new Tractor();
        $validator = Validator::make(
            request()->all(),
            [
                'tractor_name' => [
                    'required', 
                    Rule::unique($model->getTable())->ignore($id, $model->uniqueKey())
                ]
            ]
        );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }    

        $model = $model->findByKey($id);
        if (
            Auth::user()->user_type !== User::USER_TYPE_SUPER_ADMIN && 
            Auth::id() !== $model->created_user_id
        ) {
            return $this->commonError("You don't a have permission to update this item");
        }
        $model->fill(request()->all());
        $model->save();
        $data = new TractorResource($model);

        $this->setMessage('Tractor updated Successfully');
        return $this->asJson($data);
    }
}
