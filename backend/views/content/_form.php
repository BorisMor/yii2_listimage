<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'uploadImageFile')->fileInput() ?>

    <div class="form-group">
        <?php

        $imgThumb = $model->getImage()->getUrl(\common\models\Content::IMAGE_THUMB);
        if ($imgThumb) {
            $imgView = $model->getImage()->getUrl(\common\models\Content::IMAGE_VIEW);
            echo Html::a(Html::img($imgThumb), $imgView, ['target' => '_blank']) ;
        }

        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
