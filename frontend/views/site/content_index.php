<?php

use \common\models\Content;

/* @var $this yii\web\View */
/* @var array $models */
$this->title = 'List image';

?>

<style>
    .thumbnail {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5);
        transition: 0.3s;
        min-width: 40%;
        border-radius: 2px;
        padding: 0px;
    }

    .thumbnail .caption {
        padding: 0px;
    }

    .thumbnail-description {
        min-height: 40px;
    }

    .thumbnail:hover {
        cursor: pointer;
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 1);
    }

    .position-relative {
        height: 200px;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

<div class="row">
    <div class="col-md-2">&nbsp;</div>
    <div class="col-md-12">

        <div class="row space-16">&nbsp;</div>
        <div class="row">

            <?php
            /** @var \common\models\Content $model */
            foreach ($models as $model):
                $img = $model->getImage()->getUrl(Content::IMAGE_THUMB);
                $url = \yii\helpers\Url::toRoute(['/site/view', 'id' => $model->id]);
            ?>

            <div class="col-sm-4">
                <div class="thumbnail">
                    <div class="caption text-center" onclick="location.href='<?= $url ?>'">
                        <div class="position-relative" style="background-image: url('<?= $img ?>')">
                        </div>
                        <h4 id="thumbnail-label"><a href="https://flow.microsoft.com/en-us/connectors/shared_slack/slack/" target="_blank"><?= $model->title ?></a></h4>
                        <div class="thumbnail-description smaller"><?= $model->description ?></div>
                    </div>
                    <div class="caption card-footer text-center">
                        <ul class="list-inline">
                            <li><i class="people lighter"></i>&nbsp;<?= $model->view ?> view </li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>



        </div>
        <div class="col-md-2">&nbsp;</div>
    </div>
</div>