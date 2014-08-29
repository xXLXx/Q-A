<?php
use yii\widgets\ListView;
use yii\bootstrap\Nav;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Q-A';
?>
<div class="site-index">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="bs-example">
                <?= Html::a('Ask Question', '@web/site/questions/add', [
                    'class' => 'btn btn-success btn-top-right'
                    ]);
                ?>
                <?= Nav::widget([
                        'items' => [
                            [
                                'label'     => 'Newest',
                                'url'       => ['newest'],
                                'options'   => ['class' => isset($menu) && $menu == 'newest' ? 'active' : '']
                            ],
                            [
                                'label' => 'Featured',
                                'url' => ['featured'],
                                'options'   => ['class' => isset($menu) && $menu == 'featured' ? 'active' : '']
                            ],
                            [
                                'label' => 'Frequent',
                                'url' => ['frequent'],
                                'options'   => ['class' => isset($menu) && $menu == 'frequent' ? 'active' : '']
                            ],
                            [
                                'label' => 'Tags',
                                'url' => ['tags'],
                                'options'   => ['class' => isset($menu) && $menu == 'tags' ? 'active' : '']
                            ],
                            [
                                'label' => 'Unanswered',
                                'url' => ['unanswered'],
                                'options'   => ['class' => isset($menu) && $menu == 'unanswered' ? 'active' : '']
                            ],
                        ],
                        'options'   => ['class' => 'nav nav-pills']
                    ]);
                ?>
            </div>
            <div class="highlight">
                <?php
                    if(isset($dataProvider)){
                        ListView::widget([
                            'dataProvider'  => $dataProvider,
                        ]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>
