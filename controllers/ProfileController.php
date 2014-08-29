<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use yii\data\ActiveDataProvider;

class ProfileController extends \yii\web\Controller
{
	public function actionIndex(){
		return $this->actionQuestions();
	}

	public function actionQuestions(){
		$menu = 'questions';
		$dataProvider = new ActiveDataProvider([
            'query' => Question::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy('created_at'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
		return $this->render('index', compact('menu', 'dataProvider'));
	}

	public function actionAnswers(){
		$menu = 'answers';
		return $this->render('index', compact('menu'));
	}

	public function actionTags(){
		$menu = 'tags';
		return $this->render('index', compact('menu'));
	}
}