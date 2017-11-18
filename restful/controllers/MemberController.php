<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/11/2017
 * Time: 8:36 AM
 */
namespace restful\controllers;

use restful\component\ApiController;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use restful\models\MemberForm;

/**
 * Member controller
 */
class MemberController extends ApiController
{
    public $modelClass = 'restful\models\MemberForm';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
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
        $memberInfo = MemberForm::find()
            ->select(['member_id', 'member_name', 'portrait', 'telephone', 'sex'])
            ->where([])
            ->asArray(true)
            ->one();
        var_dump($memberInfo);

//        return $memberInfo;
    }

}
