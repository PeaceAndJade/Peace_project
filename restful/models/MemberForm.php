<?php

namespace restful\models;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property integer $member_id
 * @property integer $country_id
 * @property string $member_name
 * @property string $password
 * @property string $api_token
 * @property string $telephone
 * @property string $email
 * @property integer $portrait
 * @property integer $sex
 * @property integer $info_deep
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $locked
 * @property integer $closed
 */
class MemberForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'portrait', 'sex', 'info_deep', 'create_time', 'update_time', 'locked', 'closed'], 'integer'],
            [['member_name'], 'string', 'max' => 30],
            [['password', 'api_token'], 'string', 'max' => 60],
            [['telephone'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'country_id' => 'Country ID',
            'member_name' => 'Member Name',
            'password' => 'Password',
            'api_token' => 'Api Token',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'portrait' => 'Portrait',
            'sex' => 'Sex',
            'info_deep' => 'Info Deep',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'locked' => 'Locked',
            'closed' => 'Closed',
        ];
    }
}
