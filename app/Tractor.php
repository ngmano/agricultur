<?php

namespace App;

use App\CModel;

class Tractor extends CModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tractor_name'
    ];

    /**
     * The attributes that table unique key.
     *
     * @var string
     */
    protected $uniqueKey = 'tractor_key';

    /**
     * The attributes that enable unique key generation.
     *
     * @var string
     */
    protected $keyGenerate = true;
    
    /**
	 * Get Unique key to generate key
	 * @return string
	*/
    public static function uniqueKey()
    {
        $self = new self();
        return $self->uniqueKey;
    }

    public function findByKey($key)
    {
        $model = self::where('tractor_key', $key)->first();
        return $model;
    }
}
