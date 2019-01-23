<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 20.12.18
 * Time: 15:10
 */

namespace nikitich\simpletranslatemanager\assets;


class StmAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@nikitich/simpletranslatemanager/assets';

    public $css = [
        'css/simpletranslatemanager.css',
    ];

    public $js = [
        'js/simpletranslatemanager.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'nikitich\simpletranslatemanager\assets\SweetAlertAsset',
        'nikitich\simpletranslatemanager\assets\LoadingOverlayAsset',
    ];

}