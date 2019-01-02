<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 02.01.19
 * Time: 13:50
 */

use nikitich\simpletranslatemanager\services\StmImexService;

/* @var $this yii\web\View */
/* @var $filename string */
\nikitich\simpletranslatemanager\assets\StmAsset::register($this);
?>

<h3>Import file: <?= $filename ?></h3>

<pre class="stm-text-output"><?php StmImexService::importTranslations($filename); ?></pre>