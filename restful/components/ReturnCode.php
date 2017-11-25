<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/18/2017
 * Time: 4:52 PM
 */

namespace restful\components;

class ReturnCode
{
    // 0 success
    public static $success = [0, 'Successful operation'];
    // 1-99 system error code
    public static $data_1 = [1, 'Data structure error'];
    public static $table_10 = [10, 'Database update failed'];

    // 100-299 uniform error code
    public static $form_100 = [100, 'Form validation failed'];

    // 1000-1099 about login
    public static $login_1000 = [0, 'Login Successful'];

    // 1100-1199 about account
    public static $account_1100 = [1100, 'The account has been locked'];

}