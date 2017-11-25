<?php

namespace restful\models;

use common\component\PublicMethod;
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



class MemberLoginForm extends \yii\db\ActiveRecord
{
    public static $memberInfo = null;
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
            [['member_name', 'telephone', 'password'], 'required'],
            ['member_name', 'match', 'pattern' => '/^[(\x{4E00}-\x{9FA5})a-zA-Z][(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u', 'message' => 'Nicknames consist of letters, characters, numbers, or underscores, and can not begin with an underscore or a number.'], // 昵称由字母，汉字，数字或下划线组成，且不能以下划线或数字开头。
            ['member_name', 'string', 'max' => 30],
            ['password', 'string', 'min' => 6, 'max' => 16],
            ['password', 'match', 'pattern' => '/^\w+$/', 'message' => 'The password contains numbers, uppercase and lowercase letters, or underscores.'], // 密码包含数字、大小写字母或下划线。
            ['telephone', 'match', 'pattern' => '/^1[\d]{10}$/', 'message' => 'The phone number is 11 digits.'],  // 手机号码为11位数字。
            [['telephone', 'member_name'], 'findMember'],   // 回调函数
//            [['country_id', 'portrait', 'sex', 'info_deep', 'create_time', 'update_time', 'locked', 'closed'], 'integer'],
//            [['member_name'], 'string', 'max' => 30],
//            [['password', 'api_token'], 'string', 'max' => 60],
//            [['telephone'], 'string', 'max' => 11],
//            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * 应用场景分发
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // member name login
        $scenarios['login_member_name'] = ['member_name', 'password'];
        // telephone login
        $scenarios['login_telephone'] = ['telephone', 'password'];

        return $scenarios;
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

    /**
     * @return bool
     *
     */
    public function findMember () {
        // 用户昵称登陆
        if ((new PublicMethod())->isPhone(json_decode(file_get_contents('php://input', 'r'), true)['login_info']) === false) $where = ['member_name' => $this->member_name];
        // 电话号码登陆
        else $where = ['telephone' => $this->telephone];

        MemberLoginForm::$memberInfo = MemberForm::find()
            ->select(['member_id', 'password', 'api_token', 'update_time', 'locked', 'closed'])
            ->where($where)
            ->one();

        $key = array_keys($where)[0];
        // 判断条件
        if ($key === $this->member_name || MemberLoginForm::$memberInfo === null) {
            $this->addError('member_name', 'Without this user');
            return true;
        } elseif ($key === $this->telephone || MemberLoginForm::$memberInfo === null) {
            $this->addError('telephone', 'The phone number is not registered');
            return true;
        }

        // 密码验证
        if (!Yii::$app->getSecurity()->validatePassword($this->password, (MemberLoginForm::$memberInfo)->password)) $this->addError('password', 'Password error');
        // 账户是否冻结
        if ((MemberLoginForm::$memberInfo)->locked == true) $this->addError('locked', 'The account has been frozen,please contact the customer.');
        // 账户是否已被删除
        if ((MemberLoginForm::$memberInfo)->closed == true) $this->addError('closed', 'The account has been canceled');

        return true;
    }

}
