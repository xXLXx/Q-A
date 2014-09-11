<?php
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Comment;
use yii\helpers\Markdown;
use yii\helpers\Html;
?>

<?php
    $pageSize = isset($pageSize) ? $pageSize : 3;
    echo ListView::widget([
                    'dataProvider'  =>
                        new ActiveDataProvider([
                            'query' => Comment::find()->with(['user' => function($query){
                                            $query->select(['id', 'name']);
                                        }])
                                        ->where(['comment_for' => $commentFor, 'for_id' => $commentId])
                                        ->orderBy(['updated_at' => SORT_DESC]),
                            'pagination' => [
                                'pageSize' => $pageSize,
                            ],
                        ]),
                    'itemView' => function ($model, $key, $index, $widget) use($pageSize){
                        $showMore = '';
                        if($index == $pageSize - 1){
                            $showMore = '<br><br>'.Html::a('Show '.($widget->dataProvider->pagination->totalCount - $pageSize).' more',
                                            Yii::$app->request->absoluteUrl,
                                            ['class' => 'comment-link']);
                        }
                        return
                        '<hr>
                        <div class="row">
                            <div class="col-xs-11 col-xs-offset-1">
                                <small class="comment-item">'.
                                    Markdown::process($model->comment).
                                    ' – '.
                                    Html::a($model->user->name, '@web').' | '.
                                    Yii::$app->formatter->asRelativeTime($model->updated_at).'
                                </small>
                                '.$showMore.'
                            </div>
                        </div>';
                    },
                    'layout'        => "{items}",
                    'itemOptions'   => ['tag' => false],
                    'emptyText'     => false
                ]);
?>