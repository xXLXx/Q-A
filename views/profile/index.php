<?php
use app\models\User;
use yii\bootstrap\Nav;
use app\helpers\NavItemsGenerator;
use yii\helpers\Html;
use yii\base\Formatter;
use yii\widgets\ListView;
use yii\helpers\Markdown;
use app\helpers\TextLimiter;
use yii\helpers\Inflector;
?>
<?php
    $this->title = 'Q-A: Profile';
    $infoExceptions = ['password', 'pic_path', 'auth_key', 'access_token'];
?>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div class="col-xs-3">
            <div class="quick-button green prof-pic pull-right">
                <?= Html::img('@web/uploads/person.png', ['class' => 'img-icon']); ?>
                <a href="#">
                    <div class="overlay">
                        <p>Change Picture</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xs-8 dash-column-right">
            <div class="well">
                <div class="title recent-left">Personal Information</div>
                <div class="well-content">
                    <table id="tasks" class="table tasks">
                    <?php foreach (Yii::$app->user->identity as $key => $value): if(!in_array($key, $infoExceptions)):?>
                    <tr class="tasks-list-item">
                        <td class="task-list-title"><?= Yii::$app->user->identity->getAttributeLabel($key) ?></td>
                        <td class="tasks-list-desc">
                        <?= $key == 'created_at' || $key == 'updated_at' ? Yii::$app->formatter->asDate($value, 'M. d, Y') : $value;?>
                        </td>
                    </tr>
                    <?php endif; endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <ul class="nav pull-right search">
            <form class="nav-search" action="">
                <input type="text" name="filter">
            </form>
        </ul>
        <?= Nav::widget([
            'items'         => NavItemsGenerator::generateNavItems(['questions', 'answers', 'tags'], $menu, true),
            'options'       => ['class' => 'nav nav-tabs'],
            'encodeLabels'  => false
        ]);
        ?>
        <br>
        <div class="nav-tabs-content">
        <?php
        if(isset($dataProvider)){
            echo ListView::widget([
                'dataProvider'  => $dataProvider,
                'itemView'      => function ($model, $key, $index, $widget) use($menu){
                    $tags = '';
                    if($menu == 'questions'){
                       foreach ($model->tags as $key => $value) {
                            $tags .= '<a href="" class="tag pull-left"><small>'.$value->name.'</small></a>';
                        } 
                    }

                    return
                        '<div class="row question-list-item">
                            <div class="col-xs-1 dash-column-right">
                                <div class="well">
                                    <div class="title recent-right">
                                        <h4>'.$model->votes.'</h4>
                                        <span>votes</span>
                                    </div>'.
                                    ($menu != 'answers' ?
                                        '<div class="well-content">
                                            <h5>'.$model->answers_cnt.'</h5>
                                            <span>answers</span>
                                        </div>' : '')
                                .'</div>
                            </div>
                            <div class="col-xs-10">'.
                                '<h4>'.($menu != 'answers' ?
                                    Html::a($model->title, '@web/questions/'.$model->id) :
                                    Html::a($model->question->title, '@web/questions/'.$model->question->id)).
                                '</h4>'.
                                '<p>'.strip_tags(TextLimiter::limitByWords(Markdown::process($model->{Inflector::singularize($menu)}), 30)).'</p>
                                '.$tags.'
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