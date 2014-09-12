<?php
use yii\web\Request;
use yii\helpers\Markdown;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Answer;
use app\models\Comment;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\UserVote;
use yii\web\View;

?>

<?php
    $this->registerJsFile('@web/js/votes.js', [Yii::$app->params['appAssetPath']], ['position' => View::POS_END]);
?>
<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div id="view-question" class="bs-example" data-content="<?= $model->title ?>">
            <?= Html::a('Go Back', (Url::previous('lastRequest') == '@web/site/error' ? '@web/questions' : Url::previous('lastRequest')), [
                'class' => 'btn btn-success btn-top-right'
                ]);
            ?>
        </div>
        <div class="highlight">
            <div class="row">
                <div class="col-xs-1 text-center vote-block">
                    <?php
                        echo Html::a('<span class="glyphicon glyphicon-chevron-up vote" data-id="'.$model->id.
                            '" data-vote="1" data-for="'.UserVote::VOTE_FOR_QUESTION.'"></span>', '');
                        echo '<span class="vote_cnt">'.$model->votes.'</span>';
                        echo Html::a('<span class="glyphicon glyphicon-chevron-down vote" data-id="'.$model->id.
                            '" data-vote="-1" data-for="'.UserVote::VOTE_FOR_QUESTION.'"></span>', '');
                    ?>
                </div>
                <div class="col-xs-11">
                    <p><?= Markdown::process($model->question) ?></p>
                    <?php foreach ($model->tags as $key => $value): ?>
                        <a href="" class="tag pull-left"><small><?= $value->name ?></small></a>
                    <?php endforeach;?>
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
            <?php
                if(isset($commentsModel) and $commentsModel->comment_for == Comment::COMMENT_FOR_QUESTION):
                    echo $this->render('/comments/_form', compact('commentsModel'));
            ?>
            <?php else: ?>
            <div class="row">
                <div class="col-xs-11 col-xs-offset-1">
                    <small>
                        <?= Html::a('Add a comment',
                            '@web/questions/'.Yii::$app->request->getQueryParam('id').'/comment',
                            ['class' => 'comment-link']);
                        ?>
                    </small>
                </div>
            </div>
            <?php endif;?>
            <?=
                $this->render('/comments/_list', ['commentFor' => Comment::COMMENT_FOR_QUESTION, 'commentId' => $model->id]);
            ?>
            <br>
            <?php
                $questionBestAnswer = $model->best_answer;
                echo ListView::widget([
                    'dataProvider'  =>
                        new ActiveDataProvider([
                            'query' => Answer::find()->with(['user' => function($query){
                                            $query->select(['id', 'name']);
                                        }, 'guest', 'comments'])->where(['question_id' => $model->id]),
                        ]),
                    'itemView'      => function ($model, $key, $index, $widget) use($commentsModel, $questionBestAnswer){
                        $addAComment = '';
                        $heading = '';
                        $bestAnswer = '';

                        /**
                        * Add a Comment
                        */
                        if(isset($commentsModel) and $commentsModel->comment_for == COMMENT::COMMENT_FOR_ANSWER
                            and $commentsModel->for_id == $key){
                            $addAComment = $this->render('/comments/_form', compact('commentsModel'));
                        }
                        else{
                            $addAComment = '<div class="row">
                                                <div class="col-xs-11 col-xs-offset-1">
                                                    <small>'.
                                                        Html::a('Add a comment',
                                                            '@web/questions/'.Yii::$app->request->getQueryParam('id').'/comment/'.$model->id,
                                                            ['class' => 'comment-link']).'
                                                    </small>
                                                </div>
                                            </div>';
                        }

                        /**
                        * Heading
                        */
                        if($index == 0){
                            $heading = '<h4><span class="label label-success">'.$widget->dataProvider->pagination->totalCount.'</span> Answers</h4>';
                        }

                        /**
                        * Best Answer
                        */
                        if($model->id == $questionBestAnswer){
                            $bestAnswer = '<span class="glyphicon glyphicon-ok check-best"></span>';
                        }
                        else if(!Yii::$app->user->isGuest){
                            $bestAnswer = '<span class="glyphicon glyphicon-ok check-default" data-id="'.
                                $model->id.'" data-q="'.Yii::$app->request->getQueryParam('id').'"></span>';
                        }
                        

                        return
                            $heading.'
                            <hr>
                            <div class="row">
                                <div class="col-xs-1 text-center vote-block">'.
                                    Html::a('<span class="glyphicon glyphicon-chevron-up vote" data-id="'.$model->id.
                                        '" data-vote="1" data-for="'.UserVote::VOTE_FOR_ANSWER.'"></span>', '').
                                    '<span class="vote_cnt">'.$model->votes.'</span>'.
                                    Html::a('<span class="glyphicon glyphicon-chevron-down vote" data-id="'.$model->id.
                                        '" data-vote="-1" data-for="'.UserVote::VOTE_FOR_ANSWER.'"></span>', '').
                                    $bestAnswer.
                                '</div>
                                <div class="col-xs-11">
                                    <p>'.Markdown::process($model->answer).'</p>
                                    <div class="pull-right col-xs-3">
                                        <div class="micro-text pull-left">
                                            <i class="icon-time">
                                                <small> answered '.Yii::$app->formatter->asRelativeTime($model->updated_at).'</small>
                                            </i>
                                            <br>
                                            <div class="user-pic">
                                                <span class="glyphicon glyphicon-user"></span>
                                            </div>
                                            <small class="user-name">'.($model->user_group == Answer::USER_GROUP_GUEST ? $model->guest->name : $model->user->name).'</small>
                                        </div>
                                    </div>
                                </div>
                            </div>'.
                            $addAComment.
                            $this->render('/comments/_list', ['commentFor' => Comment::COMMENT_FOR_ANSWER, 'commentId' => $model->id]);
                    },
                    'layout'        => "{items}",
                    'itemOptions'   => ['tag' => false],
                    'emptyText'     => false
                ]);
            ?>
            <hr>
            <h4>Your Answer</h4>
            <?php 
                echo $this->render('/answers/_form', compact('answerModel', 'guestModel'));
            ?>
        </div>
    </div>
</div>