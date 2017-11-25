<?php

namespace restful\models;

use Yii;
use yii\db\Expression;

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
    public static $logData = null;
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
            'login_log_id' => Yii::t('restful', 'Login Log ID'),
            'member_id' => Yii::t('restful', 'Member ID'),
            'login_time' => Yii::t('restful', 'Login Time'),
            'login_ip' => Yii::t('restful', 'Login Ip'),
            'login_system' => Yii::t('restful', 'Login System'),
            'login_browser' => Yii::t('restful', 'Login Browser'),
            'lat' => Yii::t('restful', 'Lat'),
            'lng' => Yii::t('restful', 'Lng'),
        ];
    }

    /**
     * @param $event
     * @return bool
     * 准备日志数据
     */
    static public function loginUsualLog ($event) {
        $data = [
            'member_id' => $event->memberId,
            'login_time' => time(),
            'login_ip' => ip2long(Yii::$app->request->getUserIP()),   // new Expression('inet_aton(' .  . ')'),
        ];
        $agents = explode(' ', Yii::$app->request->userAgent);
        $data['login_system'] = (new LoginLogForm())->systemInfo($agents);
        $data['login_browser'] = (new LoginLogForm())->browserInfo($agents);
        self::$logData = $data;
        return true;
    }

    /**
     * 系统信息判断
     */
    public function systemInfo ($agents) {
        $string = 'windows10 x64';

        return $string;
    }

    /**
     * 浏览器信息判断
     */
    public function browserInfo ($agents) {
        $string = 'Chrome';

        return $string;
    }

}
