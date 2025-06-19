<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Request extends ActiveRecord
{
    const WORK_TYPE_ASSESSMENT = 'allapotfelmeres';
    const WORK_TYPE_FOUNDATION = 'alapozas_elokeszites';
    const WORK_TYPE_CONSTRUCTION = 'epitekzes';
    const WORK_TYPE_INSPECTION = 'muszaki_ellenorzes';

    public static function tableName()
    {
        return 'requests';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email', 'work_type', 'work_details'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['work_details', 'user_agent'], 'string'],
            [['email'], 'email'],
            [['work_type'], 'in', 'range' => [
                self::WORK_TYPE_ASSESSMENT,
                self::WORK_TYPE_FOUNDATION,
                self::WORK_TYPE_CONSTRUCTION,
                self::WORK_TYPE_INSPECTION
            ]],
            [['ip_address'], 'string', 'max' => 45],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Név',
            'email' => 'E-mail cím',
            'work_type' => 'Munka típusa',
            'work_details' => 'Munka részletezése',
            'ip_address' => 'IP cím',
            'user_agent' => 'Böngésző információ',
            'created_at' => 'Beérkezés időpontja',
            'updated_at' => 'Módosítás időpontja',
        ];
    }

    public static function getWorkTypes()
    {
        return [
            self::WORK_TYPE_ASSESSMENT => 'Állapotfelmérés',
            self::WORK_TYPE_FOUNDATION => 'Alapozás-előkészítés',
            self::WORK_TYPE_CONSTRUCTION => 'Építkezés',
            self::WORK_TYPE_INSPECTION => 'Műszaki ellenőrzés',
        ];
    }

    public function getWorkTypeLabel()
    {
        $types = self::getWorkTypes();
        return isset($types[$this->work_type]) ? $types[$this->work_type] : $this->work_type;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->ip_address = Yii::$app->request->userIP;
                $this->user_agent = Yii::$app->request->userAgent;
            }
            return true;
        }
        return false;
    }

    public static function getRequestsByMonth($year, $month)
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        return self::find()
            ->where(['>=', 'created_at', $startDate])
            ->andWhere(['<=', 'created_at', $endDate . ' 23:59:59'])
            ->orderBy('created_at ASC')
            ->all();
    }
}
