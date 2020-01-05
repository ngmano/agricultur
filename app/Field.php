<?php

namespace App;

use App\CModel;

class Field extends CModel
{
    public const FILED_TYPE_WHEAT = 1;
    public const FILED_TYPE_BROCCOLI = 2;
    public const FILED_TYPE_STRAWBERRY = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_name', 'field_type', 'area'
    ];

    /**
     * The attributes that table unique key.
     *
     * @var string
     */
    protected $uniqueKey = 'field_key';

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

    public static function getFiledTypeList(): array
    {
        $list = [
            [
                'type' => self::FILED_TYPE_WHEAT,
                'label' => 'Wheat'
            ],
            [
                'type' => self::FILED_TYPE_BROCCOLI,
                'label' => 'Broccoli'
            ],
            [
                'type' => self::FILED_TYPE_STRAWBERRY,
                'label' => 'Strawberry'
            ]
        ];

        return $list;
    }

    public static function getFieldTypeLabel($type)
    {
        $list = self::getFiledTypeList();
        foreach ($list as $key => $value) {
            if ((int)$type === (int)$value['type']) {
                return $value['label'];
                break;
            }
        }

        return '';
    }

    public function findByKey($key)
    {
        $model = self::where('field_key', $key)->first();
        return $model;
    }
}
