<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/18/2017
 * Time: 4:26 PM
 */

namespace common\component;

class PublicMethod
{
    /**
     * 电话号码认证
     */
    public function isPhone ($telephone) {
        if (!preg_match('/^[1][\d]{10}$/', $telephone)) return false;
        return true;
    }
}