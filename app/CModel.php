<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;
use App;
use DB;
use App\Helpers\Common;
use Illuminate\Support\Facades\Auth;

class CModel extends Model
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
            if (Auth::check()) {
                $model->created_user_id = Auth::id();
            }
        });

        self::updating(function($model){
            $model->updated_at = date('Y-m-d H:i:s');
            if (Auth::check()) {
                $model->created_user_id = Auth::id();
            }
        });
    }    

    public static function tableName()
    {
        $self = new static();
        return $self->getTable();
    }    

    public static function instance()
    {
        $self = new static();
        return $self;
    }
}
