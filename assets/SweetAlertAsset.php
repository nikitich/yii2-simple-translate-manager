<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 20.12.18
 * Time: 15:07
 */

namespace nikitich\simpletranslatemanager\assets;


class SweetAlertAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/sweetalert/dist';
    public $css = [
        'sweetalert.css',
    ];
    public $js = [
        'sweetalert.min.js'
    ];
}