<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/11/2017
 * Time: 8:36 AM
 */
namespace restful\controllers;

use common\component\PublicMethod;
use restful\components\ApiController;
use restful\components\ReturnCode;
use restful\events\UserLoginLogEvent;
use restful\models\LoginLogForm;
use restful\models\MemberLoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use restful\models\MemberForm;
use yii\i18n\DbMessageSource;

/**
 * Member controller
 */
class MemberController extends ApiController
{
    public $modelClass = 'restful\models\MemberForm';
    // 事件绑定
    const EVENT_LOGIN_USUAL = 'user_login_log';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
//        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => [],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['index', 'login-usual'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex () {
//        var_dump($this->phpInput);
        $memberInfo = MemberForm::find()
            ->select(['member_id', 'member_name', 'portrait', 'telephone', 'sex'])
            ->where([])
            ->asArray(true)
            ->one();
        //
        $redis = Yii::$app->redis;
        $redis->executeCommand('SETEX', ['message', 60, 'It is me']);
        var_dump($redis->executeCommand('GET', ['message']));
        //
        $translate = Yii::t('restful', 'Who are you', [], 'zh-CN');
        var_dump($translate);
        return [[0, ''], $memberInfo, false];
    }

    /**
     * 普通登陆
     * 用户昵称和密码
     * 用户电话和密码
     */
    public function actionLoginUsual () {
        // 昵称和密码登录
        if ((new PublicMethod())->isPhone($this->phpInput['login_info']) === false) $scenario = 'member_name';
        // 电话号码和密码登陆
        else $scenario = 'telephone';
        $memberLoginModel = new MemberLoginForm();
        $memberLoginModel->scenario = 'login_' . $scenario;
        $memberLoginModel->setAttributes([$scenario => $this->phpInput['login_info'], 'password' => $this->phpInput['password']]);
        $memberLoginModel->validate();
        if ($memberLoginModel->hasErrors()) return [[ReturnCode::$form_100[0], $memberLoginModel->getErrors()], [], false];
        // 更新和写日志
        // 生成api_token
        $transaction = Yii::$app->db->beginTransaction();
        $memberLoginModel = MemberLoginForm::$memberInfo;
        $token = substr(md5(time()), 2) . substr(md5($this->phpInput['login_info'] . time()), 2);
        $memberLoginModel->setAttributes(['api_token' => $token, 'update_time' => time()]);
        $memberLoginModel->save();
        if ($memberLoginModel->hasErrors()) return [[ReturnCode::$table_10[0], $memberLoginModel->getErrors()], [], false];

        // 登陆日志，触发yii2事件
        $this->on(self::EVENT_LOGIN_USUAL, ['restful\models\LoginLogForm', 'loginUsualLog']);
        $event = new UserLoginLogEvent();
        $event->memberId = $memberLoginModel->member_id;
        $this->trigger(self::EVENT_LOGIN_USUAL, $event);

        $data = LoginLogForm::$logData;
        if (!$data) return [ReturnCode::$data_1, [], false];
        $loginLogFormModel = new LoginLogForm();
        $loginLogFormModel->setAttributes($data);
        $loginLogFormModel->validate();
        if ($loginLogFormModel->hasErrors()) return [[ReturnCode::$table_10[0], $loginLogFormModel->getErrors()], [], false];
        $loginLogFormModel->save();

        $transaction->commit();
        return [ReturnCode::$login_1000, ['api_token' => $token], false];
    }

}
