<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Input;
use App;
use DB;
use App\Helpers\Common;

class CAuthModel extends Authenticatable
{	    
	public static function boot()
    {   
        parent::boot();            
        
        self::saving(function($model){   
                        
            if(!$model->exists && property_exists($model, 'keyGenerate') == true && $model->keyGenerate = true){
                $key = Common::generateRandomString($model->getTable(),$model->uniqueKey);
                $model->{$model->uniqueKey} = $key;            
            }                        
		});
		
        self::creating(function($model){
            $model->created_at = date('Y-m-d H:i:s');
        });

        self::updating(function($model){
            $model->updated_at = date('Y-m-d H:i:s');
        });
    }    

    public static function tableName()
    {
        $self = new static();
        return $self->getTable();
    }    
}
