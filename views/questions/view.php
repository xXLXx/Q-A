<?php
use yii\web\Request;
use yii\helpers\Markdown;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Answer;
?>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div id="view-question" class="bs-example" data-content="<?= $model->title ?>">
            <?= Html::a('Go Back', Url::previous('lastRequest'), [
                'class' => 'btn btn-success btn-top-right'
                ]);
            ?>
        </div>
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
                    <div class="pull-right col-xs-3">
                        <div class="micro-text pull-left">
                            <i class="icon-time">
                                <small> asked <?= Yii::$app->formatter->asRelativeTime($model->updated_at) ?></small>
                            </i>
                            <br>
                            <div class="user-pic">
                                <span class="glyphicon glyphicon-user"></span>
                            </div>
                            <small class="user-name"><?= $model->user->name?></small>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?php $x = 0; foreach ($model->answers as $key => $value): ?>
            <?php if($x++ == 0): ?>
                <h4><span class="label label-success"><?= sizeof($model->answers) ?></span> Answers</h4>
            <?php endif;?>
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
                    <div class="pull-right col-xs-3">
                        <div class="micro-text pull-left">
                            <i class="icon-time">
                                <small> answered <?= Yii::$app->formatter->asRelativeTime($value->updated_at) ?></small>
                            </i>
                            <br>
                            <div class="user-pic">
                                <span class="glyphicon glyphicon-user"></span>
                            </div>
                            <small class="user-name"><?= $value->user_group == Answer::USER_GROUP_GUEST ? $value->guest->name : $value->user->name ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <hr>
            <h4>Your Answer</h4>
            <?php 
                echo $this->render('/answers/_form', compact('answerModel', 'guestModel'));
            ?>
        </div>
    </div>
</div>