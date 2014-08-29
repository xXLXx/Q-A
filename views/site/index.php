<?php
use yii\widgets\ListView;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use app\helpers\NavItemsGenerator;
/* @var $this yii\web\View */
$this->title = 'Q-A';
?>
<div class="site-index">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="bs-example">
                <?= Html::a('Ask Question', '@web/questions/add', [
                    'class' => 'btn btn-success btn-top-right'
                    ]);
                ?>
                <?= Nav::widget([
                        'items'     => NavItemsGenerator::generateNavItems(['newest', 'featured', 'frequent', 'tags', 'unanswered'], $menu),
                        'options'   => ['class' => 'nav nav-pills']
                    ]);
                ?>
            </div>
            <div class="highlight">
                <?php
                    if(isset($dataProvider)){
                        echo ListView::widget([
                            'dataProvider'  => $dataProvider,
                        ]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>
