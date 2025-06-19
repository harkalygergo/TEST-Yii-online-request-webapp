<?php
namespace app\models;

use Yii;
use yii\base\Model;

class RequestForm extends Model
{
    public $name;
    public $email;
    public $work_type;
    public $work_details;

    public function rules()
    {
        return [
            [['name', 'email', 'work_type', 'work_details'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['work_details'], 'string'],
            [['work_type'], 'in', 'range' => array_keys(Request::getWorkTypes())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Név *',
            'email' => 'E-mail cím *',
            'work_type' => 'Munka típusa *',
            'work_details' => 'Munka részletezése *',
        ];
    }

    public function saveRequest()
    {
        if ($this->validate()) {
            $request = new Request();
            $request->name = $this->name;
            $request->email = $this->email;
            $request->work_type = $this->work_type;
            $request->work_details = $this->work_details;

            return $request->save();
        }
        return false;
    }
}
