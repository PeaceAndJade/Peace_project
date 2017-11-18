<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/18/2017
 * Time: 4:52 PM
 */

namespace restful\component;

class ReturnCode
{
    // 0 正确
    public static $success = [0, '操作成功'];
    // 1-99 系统错误代码
    public static $data_1 = [1, '数据结构错误'];
    public static $table_10 = [10, '数据库更新失败'];

    // 100-299 统一性错误代码
    public static $form_100 = [100, '表单验证失败'];

    // 1000-1099 登陆相关
    public static $login_1000 = [0, '登陆成功'];

    // 1100-1199
    public static $account_1100 = [1100, '该账户被锁定'];

}