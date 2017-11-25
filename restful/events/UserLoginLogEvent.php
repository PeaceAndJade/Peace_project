<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/19/2017
 * Time: 10:57 AM
 */

namespace restful\events;

use yii\base\Event;

class UserLoginLogEvent extends Event
{
    public $memberId = 0;

}