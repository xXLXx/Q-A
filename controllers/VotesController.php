<?php

namespace app\controllers;

use Yii;
use app\models\UserVote;
use app\models\Question;
use app\models\Answer;

class VotesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionVote(){
        Yii::$app->response->format = 'json';
        $userId = Yii::$app->user->identity->id;
        $voteFor = Yii::$app->request->getQueryParam('voteFor');
        $forId = Yii::$app->request->getQueryParam('forId');

        if(!Yii::$app->user->isGuest and !UserVote::findOne([
                'user_id'   => $userId,
                'vote_for'  => $voteFor,
                'for_id'    => $forId])){
            $userVote = new UserVote();
            $userVote->user_id = $userId;
            $userVote->vote_for = $voteFor;
            $userVote->for_id = $forId;
            
            if($userVote->save()){
                $model;
                if($userVote->vote_for == UserVote::VOTE_FOR_ANSWER){
                    $model = Answer::findOne($userVote->for_id);
                }
                else{
                    $model = Question::findOne($userVote->for_id);
                }
                $model->votes += Yii::$app->request->getQueryParam('vote');
                
                if(!$model->save()){
                    return false;
                }
            }
            else{
                return false;
            }

            return true;
        }

        return false;
    }
}
