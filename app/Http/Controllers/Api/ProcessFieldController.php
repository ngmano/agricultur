<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CController;
use Auth;
use Validator;
use App\{
    ProcessField,
    Field,
    Tractor,
    User
};
use App\Http\Resources\Api\ProcessFieldResource;
use Illuminate\Validation\Rule;

class ProcessFieldController extends CController
{
    public function index()
    {
        $model = ProcessField::from(ProcessField::instance()->tableName().' AS PF')
            ->join(Tractor::instance()->tableName().' AS T', 'T.id', '=', 'PF.tractor_id')
            ->join(Field::instance()->tableName().' AS F', 'F.id', '=', 'PF.field_id')
            ->select(
                'PF.*', 
                'T.tractor_name',
                'T.tractor_key', 
                'F.field_name', 
                'F.field_type',
                'F.field_key'
            )->get();

        $data = ProcessFieldResource::collection($model);

        $this->setMessage('Process Field List');
        return $this->asJson($data);
    }

    public function store()
    {
        if ((int)Auth::user()->user_type !== User::USER_TYPE_SUPER_ADMIN) {
            return $this->commonError("You don't have a permission to access this");
        }

        $validator = Validator::make(
                request()->all(),
                [
                    'tractor_key' => 'required',
                    'field_key' => 'required',
                    'area' => 'required|numeric',
                    'date' => 'required|date',
                ]
            );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }    
        
        $modelTractor = Tractor::instance()->findByKey(request()->input('tractor_key'));
        if ($modelTractor === null) {
            return $this->commonError('Invalid tractor');
        }

        $modelField = Field::instance()->findByKey(request()->input('field_key'));
        if ($modelField === null) {
            return $this->commonError('Invalid field');
        }

        if ((int)request()->input('area') > (int)$modelField->area) {
            return $this->commonError(
                sprintf('Process area should be less than field area(%s)', $modelField->area)
            );
        }

        $processDate = date('Y-m-d', strtotime(request()->input('date')));
        if (strtotime(date('Y-m-d')) > strtotime($processDate)) {
            return $this->commonError('Process date should not less than today');
        }
        
        $model = new ProcessField();
        $model->fill(request()->all());
        $model->tractor_id = $modelTractor->getKey();
        $model->field_id = $modelField->getKey();
        $model->date = date('Y-m-d', strtotime(request()->input('date')));
        $model->save();
        
        $this->setMessage('Process Field Created Successfully');
        return $this->asJson();
    }

    public function show($id)
    {
        $model = ProcessField::instance()->findByKey($id);
        if ($model === null) {
            return $this->commonError('Invalid Data');
        }
        $data = new ProcessFieldResource($model);

        $this->setMessage('Process Field View');
        return $this->asJson($data);
    }

    public function update($id)
    {
        if ((int)Auth::user()->user_type !== User::USER_TYPE_SUPER_ADMIN) {
            return $this->commonError("You don't have a permission to access this");
        }

        $validator = Validator::make(
            request()->all(),
            [
                'tractor_key' => 'required',
                'field_key' => 'required',
                'area' => 'required|numeric',
                'date' => 'required|date',
            ]
        );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }    
        
        $modelTractor = Tractor::instance()->findByKey(request()->input('tractor_key'));
        if ($modelTractor === null) {
            return $this->commonError('Invalid tractor');
        }

        $modelField = Field::instance()->findByKey(request()->input('field_key'));
        if ($modelField === null) {
            return $this->commonError('Invalid field');
        }

        if ((int)request()->input('area') > (int)$modelField->area) {
            return $this->commonError(
                sprintf('Process area should be less than field area(%s)', $modelField->area)
            );
        }

        $model = ProcessField::where('process_field_key', $id)->first();
        if ($model === null) {
            return $this->commonError('Invalid data');
        }

        $model->fill(request()->all());
        $model->tractor_id = $modelTractor->getKey();
        $model->field_id = $modelField->getKey();
        $model->date = date('Y-m-d', strtotime(request()->input('date')));
        $model->save();

        $model = ProcessField::instance()->findByKey($id);
        $data = new ProcessFieldResource($model);

        $this->setMessage('Process field updated successfully');
        return $this->asJson($data);
    }

    public function changeStatus()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'process_field_key' => 'required',
                'status' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->validateError($validator->errors());
        }

        if ((int)Auth::user()->user_type !== User::USER_TYPE_MODERATOR) {
            return $this->commonError("You don't have a permission to access this");
        }

        $model = ProcessField::where('process_field_key', request()->input('process_field_key'))
            ->first();
        if ($model === null) {
            return $this_>commonError('Invalid Data');
        }

        $model->status = request()->input('status');
        $model->save();

        $this->setMessage('Status Changed Successfully');
        return $this->asJson();
    }
}
