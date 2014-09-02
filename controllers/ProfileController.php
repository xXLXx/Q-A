<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use app\models\Answer;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex(){
        return $this->actionQuestions();
    }

    public function actionQuestions(){
        $menu = 'questions';
        $dataProvider = new ActiveDataProvider([
            'query'         => Question::find()->leftJoin('answers', 'question_id = questions.id')
                                ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                                ->where(['user_id' => Yii::$app->user->identity->id])
                                ->groupBy('questions.id')
                                ->orderBy(['created_at' => SORT_DESC]),
            'pagination'    => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionAnswers(){
        $menu = 'answers';
        $dataProvider = new ActiveDataProvider([
            'query'         => Answer::find()
                                ->with('question')
                                ->where(['name' => Yii::$app->user->identity->id])
                                ->orderBy(['created_at' => SORT_DESC]),
            'pagination'    => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionTags(){
        $menu = 'tags';
        return $this->render('index', compact('menu'));
    }
}