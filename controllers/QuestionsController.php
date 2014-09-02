<?php

namespace app\controllers;

use Yii;
use app\models\Question;

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
            Yii::$app->getResponse()->redirect('@web/profile');
        } else {
            return $this->render('add', compact('model'));
        }
    }

    public function actionView(){
        $model = Question::find()->where(['id' => Yii::$app->request->getQueryParam('id')])->one();
        return $this->render('view', compact('model'));
    }
}