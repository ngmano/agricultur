<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
Use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class CController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $message;
    protected $status;
    protected $data;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','test']]);
    }
    
    /**
     * @param array $result 
     * @return data with success 
     */ 
    public function asJson($result = null)
    {  
        $this->status = Response::HTTP_OK;
        if($result !== null) {
            $this->data = $result;
        }
        return $this->prepareResponse();
    }

    /**
     * Set common message
     */
    public function setMessage($message = '')
    {
        $this->message = $message;
    }

    /**
     * @param string $message
     * @return expectation failed 
     */
    public function commonError($message = '')
    {                
        $this->status = Response::HTTP_EXPECTATION_FAILED;
        $this->message = $message;
        return $this->prepareResponse();
    }

    /**
     * @param array $errors
     * @param boolean $return if you don't want to return with validate error send boolean (false)
     * @return errors with fail
     */ 
    public function validateError($errors = null, $return = true)
    {
        $this->status = Response::HTTP_UNPROCESSABLE_ENTITY;
        if( $errors != null && is_string($errors) ) {

            // $response['errors'][] = $errors;
            $this->message = $errors;

        } elseif( $errors != null && is_object($errors) ) {
            $errorMsg = '';
            $count = count($errors->all());
            
            foreach ($errors->all() as $key => $error) {
                if($key+1 == $count) {
                    $errorMsg .= $error;
                } else {
                    $errorMsg .= $error.",";
                }                
            }
            // $this->errors = $errorMsg;
            $this->message = $errorMsg;

        } elseif( $errors != null && is_array($errors) ) {
            $errorMsg = '';
            foreach ($errors as $key => $error) {
                if(count($errors) == $key+1) {
                    $errorMsg .= $error;
                } else {
                    $errorMsg .= $error.",";
                }                
            }
            //$this->errors = $errorMsg;
            $this->message = $errorMsg;
        }
        if($return == true) {
            return $this->prepareResponse();
        }        
    }

    public function prepareResponse(): object
    {        
        if ($this->data === null) {
            $this->data = [];
        }

        $response = [
            'status' => $this->status, 
            'message' => $this->message,
            'time'=> time(),
            'data' => $this->data
        ];        

        return response()->json($response, $this->status);
    } 
}
