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
            'member_id' => Yii::t('restful', 'Member ID'),
            'country_id' => Yii::t('restful', 'Country ID'),
            'member_name' => Yii::t('restful', 'Member Name'),
            'password' => Yii::t('restful', 'Password'),
            'api_token' => Yii::t('restful', 'Api Token'),
            'telephone' => Yii::t('restful', 'Telephone'),
            'email' => Yii::t('restful', 'Email'),
            'portrait' => Yii::t('restful', 'Portrait'),
            'sex' => Yii::t('restful', 'Sex'),
            'info_deep' => Yii::t('restful', 'Info Deep'),
            'create_time' => Yii::t('restful', 'Create Time'),
            'update_time' => Yii::t('restful', 'Update Time'),
            'locked' => Yii::t('restful', 'Locked'),
            'closed' => Yii::t('restful', 'Closed'),
        ];
    }
}
