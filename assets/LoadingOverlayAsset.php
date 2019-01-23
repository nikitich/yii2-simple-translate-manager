<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 23.01.19
 * Time: 18:59
 */

namespace nikitich\simpletranslatemanager\assets;

use yii\web\AssetBundle;

class LoadingOverlayAsset extends AssetBundle
{
    public $sourcePath = '@bower/gasparesganga-jquery-loading-overlay';

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        if (YII_ENV_DEV) {
            $this->js = ['dist/loadingoverlay.js'];
        } else {
            $this->js = ['dist/loadingoverlay.min.js'];
        }
    }
}