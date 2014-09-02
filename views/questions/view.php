<?php
use yii\web\Request;
use yii\helpers\Markdown;
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div id="view-question" class="bs-example" data-content="<?= $model->title ?>"></div>
        <div class="highlight">
            <div class="row">
                <div class="col-xs-1 text-center vote-block">
                    <?php
                        echo Html::a('<span class="glyphicon glyphicon-chevron-up"></span>', '');
                        echo $model->votes;
                        echo Html::a('<span class="glyphicon glyphicon-chevron-down"></span>', '');
                    ?>

                </div>
                <div class="col-xs-11">
                    <p><?= Markdown::process($model->question) ?></p>
                    <div class="micro-text">
                        <i class="icon-time pull-right">
                            <small> asked <?= Yii::$app->formatter->asRelativeTime($model->updated_at) ?></small>
                        </i>
                    </div>
                </div>
            </div>
            <br>
            <h4><span class="label label-success"><?= sizeof($model->answers) ?></span> Answers</h4>
            <?php foreach ($model->answers as $key => $value): ?>
            <hr>
            <div class="row">
                <div class="col-xs-1 text-center vote-block">
                    <?php
                        echo Html::a('<span class="glyphicon glyphicon-chevron-up"></span>', '');
                        echo $value->votes;
                        echo Html::a('<span class="glyphicon glyphicon-chevron-down"></span>', '');
                    ?>

                </div>
                <div class="col-xs-11">
                    <p><?= Markdown::process($value->answer) ?></p>
                    <div class="micro-text">
                        <i class="icon-time pull-right">
                            <small> answered <?= Yii::$app->formatter->asRelativeTime($value->updated_at) ?></small>
                        </i>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>