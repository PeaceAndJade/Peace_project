<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%login_log}}".
 *
 * @property integer $login_log_id
 * @property integer $member_id
 * @property integer $login_time
 * @property integer $login_ip
 * @property string $login_system
 * @property string $login_browser
 * @property double $lat
 * @property double $lng
 */
class LoginLogForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%login_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'login_time', 'login_ip'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['login_system', 'login_browser'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login_log_id' => 'Login Log ID',
            'member_id' => 'Member ID',
            'login_time' => 'Login Time',
            'login_ip' => 'Login Ip',
            'login_system' => 'Login System',
            'login_browser' => 'Login Browser',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

}
