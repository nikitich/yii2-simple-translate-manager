<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 13.12.18
 * Time: 12:40
 */

namespace nikitich\simpletranslatemanager\controllers;


use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}