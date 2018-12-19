<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 11.12.18
 * Time: 14:19
 */

namespace nikitich\simpletranslatemanager;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'nikitich\simpletranslatemanager\controllers';

    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->i18n->translations['simpletranslatemanager'])) {
            Yii::$app->i18n->translations['simpletranslatemanager'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                // 'sourceLanguage' => 'en',
                'forceTranslation' => true,
                'basePath' => '@nikitich/simpletranslatemanager/messages',
            ];
        }

        if (1==0) {
            Yii::$app->getUrlManager()->addRules([
                '/i18n/translations/update/<category:\w+>/<alias:\w+>/<language:\w+>' => '/i18n/translations/update',
            ], false);
        }


    }

}