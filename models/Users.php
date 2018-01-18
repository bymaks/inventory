<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $first_name
 * @property string $second_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property integer $birthday
 * @property integer $bonus
 * @property integer $money
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password_reset_token
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $status
 */
class Users extends \yii\db\ActiveRecord
{
    public $confirmPassword='';
    public $passwordNew='';
    public $userNameSearch='';
    public $roleName='';
    public $promo;


    //*********************
    //*********************
    //*********************
    public static function tableName(){
        return 'users';
    }

    public static function getDb(){
        return \Yii::$app->db;
    }

    public function rules(){
        return [
            [['name', 'first_name', 'second_name', 'phone',], 'required'],
            [['birthday', 'date_creation', 'date_update_row'], 'safe'],
            [['gender', 'time_out','created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['first_name', 'second_name', 'last_name', 'password_reset_token', 'password_hash', 'auth_key'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 12],
            [['phone'], 'unique'],
            [['email'], 'string', 'max' => 128],
            [['sms_key'], 'string', 'max' => 60],
            [['passwordNew', 'confirmPassword'], 'validPass'],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'name' => 'Name',
            'first_name' => 'First Name',
            'second_name' => 'Second Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'birthday' => 'Birthday',
            'password_reset_token' => 'Password Reset Token',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'gender' => 'Gender',
            'sms_key' => 'Sms Key',
            'time_out' => 'Time Out',
            'date_creation' => 'Date Creation',
            'date_update_row' => 'Date Update Row',
            'status' => 'Status',
        ];
    }

    public function getAuthAssignment(){
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function getItemName(){
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    //*********************
    //*********************
    //*********************



    public function validPass($attribute, $params){
        //TODO:: валидация пароля и поставить hash

        if(strlen($this->passwordNew)>0){
            if(strlen($this->confirmPassword)>0){
                if(strcmp($this->confirmPassword, $this->passwordNew)==0) {
                    $this->password_hash = Yii::$app->security->generatePasswordHash($this->passwordNew);
                    $this->auth_key = Yii::$app->security->generateRandomString();
                }
                else{
                    $this->addError('confirmPassword', 'Пароли не совпадают');
                }
            }
            else{
                $this->addError('confirmPassword', 'Введите подтверждение пароля');
            }
        }
        else{
            $this->addError('passwordNew', 'Введите пароль');
        }

        $this->passwordNew='';
        $this->confirmPassword='';

    }

    public static function getUserByPhone($phone = null){

        if(!empty($phone)) {
            $user = Users::find()->where(['phone' => $phone])->one();
            if(!empty($user))
                return $user;
            else
                return false;
        }
        else
            return false;

    }


    public function getRole(){
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }


}
