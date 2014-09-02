<?php
use yii\widgets\ListView;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use app\helpers\NavItemsGenerator;
use yii\helpers\Markdown;
use app\helpers\TextLimiter;
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
                            'itemView'      => function ($model, $key, $index, $widget){
                                return
                                    '<div class="row question-list-item">
                                        <div class="col-xs-1 dash-column-right">
                                            <div class="well">
                                                <div class="title recent-right">
                                                    <h4>'.$model->votes.'</h4>
                                                    <span>votes</span>
                                                </div>
                                                <div class="well-content">
                                                    <h5>'.$model->answers_cnt.'</h5>
                                                    <span>answers</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-10">
                                            <h4>'.Html::a($model->title, '@web/questions/'.$model->id).'</h4>
                                            <p>'.strip_tags(TextLimiter::limitByWords(Markdown::process($model->question), 30)).'</p>
                                            <div class="micro-text">
                                                <i class="icon-time pull-right">
                                                    <small> asked '.Yii::$app->formatter->asRelativeTime($model->updated_at).'</small>
                                                </i>
                                            </div>
                                        </div>
                                    </div>';
                            },
                            'layout'        => "{items}\n{pager}",
                            'pager'         => ['options' => ['class' => 'pagination pull-right']],
                            'itemOptions'   => ['tag' => false]
                        ]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>
