<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CController;
use Auth;
use App\{
    ProcessField
};
use App\Http\Resources\Api\ReportResource;
use Illuminate\Support\Arr;

class ReportController extends CController
{
    public function index()
    {
        $report = ProcessField::instance()->getReport(request()->all());
        $data['data'] = ReportResource::collection($report);
        $processedArea = Arr::pluck($report->toArray(), 'area');
        $data['total_processed_area'] = array_sum($processedArea); 

        $this->setMessage('Report List');
        return $this->asJson($data);
    }
}
