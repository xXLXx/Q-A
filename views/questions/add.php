<?php
use yii\widgets\ListView;
use yii\bootstrap\Nav;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Q-A: Question';
?>
<div class="site-index">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div id="add-question" class="bs-example">
                <?= Html::a('Nevermind', '@web/site', [
                    'class' => 'btn btn-success btn-top-right top-right-red',
                    ]);
                ?>
            </div>
            <div class="highlight">
                <?= $this->render('_form', compact('model')); ?>
            </div>
        </div>
    </div>
</div>
