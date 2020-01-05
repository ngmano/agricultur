<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CController;
use Auth;
use Validator;
use App\{
    Field,
    User
};
use App\Http\Resources\Api\FieldResource;
use Illuminate\Validation\Rule;

class FieldController extends CController
{
    public function index()
    {
        $model = Field::get();
        $data = FieldResource::collection($model);

        $this->setMessage('Field List');
        return $this->asJson($data);
    }

    public function store()
    {   
        $validator = Validator::make(
                request()->all(),
                [
                    'field_name' => 'required|unique:fields,field_name',
                    'field_type' => 'required',
                    'area' => 'required|numeric'
                ]
            );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }    

        $model = new Field();
        $model->fill(request()->all());
        $model->save();
        
        $this->setMessage('Field Created Successfully');
        return $this->asJson();
    }

    public function show($id)
    {
        $model = Field::instance()->findByKey($id);
        if ($model === null) {
            return $this->commonError('Invalid Data');
        }
        $data = new FieldResource($model);

        $this->setMessage('Field View');
        return $this->asJson($data);
    }

    public function update($id)
    {
        $model = new Field();
        $validator = Validator::make(
            request()->all(),
            [
                'field_name' => [
                    'required', 
                    Rule::unique($model->getTable())->ignore($id, $model->uniqueKey())
                ],
                'field_type' => 'required',
                'area' => 'required|numeric'
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
        $data = new FieldResource($model);

        $this->setMessage('Field updated Successfully');
        return $this->asJson($data);
    }
}
