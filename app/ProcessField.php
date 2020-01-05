<?php

namespace App;

use App\{
    CModel,
    Tractor,
    Field
};

class ProcessField extends CModel
{
    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_REJECETED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_id', 'tractor_id', 'area', 'date'
    ];

    /**
     * The attributes that table unique key.
     *
     * @var string
     */
    protected $uniqueKey = 'process_field_key';

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
        $model = self::from(self::instance()->tableName().' AS PF')
            ->join(Tractor::instance()->tableName().' AS T', 'T.id', '=', 'PF.tractor_id')
            ->join(Field::instance()->tableName().' AS F', 'F.id', '=', 'PF.field_id')
            ->select(
                'PF.*', 
                'T.tractor_name',
                'T.tractor_key', 
                'F.field_name', 
                'F.field_type',
                'F.field_key'
            )->where('PF.process_field_key', $key)
            ->first();;
        return $model;
    }

    public static function getStatusList(): array
    {
        $list = [
            [
                'type' => self::STATUS_PENDING,
                'label' => 'Pending'
            ],
            [
                'type' => self::STATUS_APPROVED,
                'label' => 'Approved'
            ],
            [
                'type' => self::STATUS_REJECETED,
                'label' => 'Rejected'
            ]
        ];

        return $list;
    }

    public static function getStatusLabel($type)
    {
        $list = self::getStatusList();
        foreach ($list as $key => $value) {
            if ((int)$type === (int)$value['type']) {
                return $value['label'];
                break;
            }
        }

        return '';
    }

    public function getReport($request)
    {
        $model = self::from(self::instance()->tableName().' AS PF')
            ->join(Tractor::instance()->tableName().' AS T', 'T.id', '=', 'PF.tractor_id')
            ->join(Field::instance()->tableName().' AS F', 'F.id', '=', 'PF.field_id')
            ->select(
                'PF.date', 
                'T.tractor_name',
                'F.field_name', 
                'F.field_type',
                'PF.area'
            )->where('PF.status', self::STATUS_APPROVED)
            ->where(function($query) use($request) {
                if (!empty($request['field'])) {
                    $query->where('F.field_name', 'like', '%'.$request["field"].'%');
                }
                if (!empty($request['tractor'])) {
                    $query->where('T.tractor_name', 'like', '%'.$request["tractor"].'%');
                }
                if (!empty($request['field_type'])) {
                    $query->where('F.field_type', $request["field_type"]);
                }
                if (!empty($request['date'])) {
                    $query->whereDate('PF.date', date('Y-m-d', strtotime($request["date"])));
                }
            })->get();
        
        return $model;
    }
}
