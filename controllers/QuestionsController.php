<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use app\models\Answer;
use app\models\Guest;

class QuestionsController extends \yii\web\Controller
{
	public function actionIndex(){
		return $this->actionAdd();
	}

	public function actionAdd()
    {
    	if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Question();
        $model->scenario = 'add';
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            Yii::$app->response->redirect('@web/profile');
        } else {
            return $this->render('add', compact('model'));
        }
    }

    public function actionView(){
        $model = Question::find()->with(['answers' => function($query){
            $query->with('user', 'guest');
        }])->where(['id' => Yii::$app->request->getQueryParam('id')])->one();
        $answerModel = new Answer();
        $guestModel = new Guest();
        if(Yii::$app->user->isGuest){
            // $answerModel->scenario = 'guest';
            $answerModel->user_group = Answer::USER_GROUP_GUEST;
        }
        else{
            // $answerModel->scenario = 'user';
            $answerModel->user_group = Answer::USER_GROUP_USER;
        }

        if($answerModel->load(Yii::$app->request->post()) and
            (!Yii::$app->user->isGuest || $guestModel->load(Yii::$app->request->post())) and
            $answerModel->add($guestModel)){
            return $this->redirect(Yii::$app->request->getQueryParam('id'));
        }
        else{
            return $this->render('view', compact('model', 'answerModel', 'guestModel'));
        }
        
    }
}