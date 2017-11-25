<?php
/**
 * Created by PhpStorm.
 * User: Peace
 * Date: 11/25/2017
 * Time: 11:15 AM
 */

namespace restful\components;

use yii\i18n\MissingTranslationEvent;

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
    }
}