<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user'; // Ensure this matches your database table name
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'unique'],
            ['password_hash', 'string', 'min' => 6],
        ];
    }

    public function setPassword($password)
    {
        // append dotenv PASSWORD_SALT to the password before hashing
        $passwordSalt = Yii::$app->params['PASSWORD_SALT'];
        if (!$passwordSalt) {
            throw new \Exception('PASSWORD_SALT is not set in params.');
        }

        if (empty($password)) {
            throw new \InvalidArgumentException('Password cannot be empty.');
        }

        $password .= $passwordSalt; // Append the salt to the password

        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        $passwordSalt = Yii::$app->params['PASSWORD_SALT'];
        $password .= $passwordSalt; // Append the salt to the password for validation

        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    // IdentityInterface methods
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
