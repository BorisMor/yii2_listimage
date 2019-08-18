<?php

/* @var \yii\web\View $thtis */
/* @var \common\models\Content $model  */

use \yii\helpers\Html;
use common\models\Content;
?>


<div class="row">
    <div class="col-md-12">
        <?= Html::a('Back', ['site/index']) ?>

        <h1><?= $model->title ?></h1>
        <p><?= $model->description ?></p>
        <?= Html::img($model->getImage()->getUrl(Content::IMAGE_VIEW)) ?>
    </div>
</div>
