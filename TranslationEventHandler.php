<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 20.12.18
 * Time: 17:24
 */

namespace nikitich\simpletranslatemanager;

use nikitich\simpletranslatemanager\models\StmCategories;
use yii\i18n\MissingTranslationEvent;
use nikitich\simpletranslatemanager\models\StmTranslations;

class TranslationEventHandler
{

    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $msg = '';

        if (YII_ENV_DEV === true) {
            if (StmCategories::findOne($event->category)) {
                $msg = "<pre style='color: red; font-weight: bold;'>@MISSING: [{$event->category}.{$event->message}] FOR LANGUAGE [{$event->language}]@</pre>";
                if ($event->sender->enableAdimPanelUrls) {
                    $action = 'create';
                    if (StmTranslations::findOne([
                            'category' => $event->category,
                            'alias'    => $event->message,
                        ])
                    ) {
                        $action = 'update';
                    }
                    $msg = "<a href='{$event->sender->I18nAdminPanelUrl}/translations/{$action}?alias={$event->message}&category={$event->category}&language_id={$event->language}' target='_blank'>{$msg}</a>";
                }
            } else {
                $msg = $event->message;
            }
        }

        $event->translatedMessage = $msg;
    }
}