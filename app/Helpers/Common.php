<?php

namespace App\Helpers;

use Session;
use Illuminate\Http\Request;
use App;
use Auth;
use DB;

class Common
{
	/**
     * Method to generate an random string of length 16 by default
     *
     * @param int $length
     * @param bool $escSpecialChar
     * @return bool|string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\Exception
     */
    public static function generateRandomString($table, $column, $length = 16)
    {
        $unique = false;
        do{
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $bytes = '';
            for ($i = 0; $i < $length; $i++) {
                $bytes .= $characters[rand(0, $charactersLength - 1)];
            }                            
            $bytes = preg_replace('/[^A-Za-z0-9 ]/', '', $bytes);            
            $randomStr = substr($bytes, 0, $length);            
            $count = DB::table($table)->where($column, '=', $randomStr)->count();
            if( $count == 0){                
                $unique = true;
            }
        }
        while(!$unique);        
        return $randomStr;
    }
}
