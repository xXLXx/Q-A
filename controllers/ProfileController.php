<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use app\models\Answer;
use yii\helpers\Url;

class ProfileController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Url::remember(Url::canonical(), 'lastRequest');
            return true;
        } else {
            return false;
        }
    }

    public function actionIndex(){
        return $this->actionQuestions();
    }

    public function actionQuestions(){
        $menu = 'questions';
        $dataProvider = new ActiveDataProvider([
            'query'         => Question::find()->leftJoin('answers', 'question_id = questions.id')
                                ->with(['tags' => function($query){
                                    $query->select(['id', 'name']);
                                }])
                                ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                                ->where(['questions.user_id' => Yii::$app->user->identity->id])
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
                                ->where([
                                    'user_id' => Yii::$app->user->identity->id,
                                    'user_group' => Answer::USER_GROUP_USER
                                    ])
                                ->orderBy(['created_at' => SORT_DESC]),
            'pagination'    => [
                'pageSize'      => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionTags(){
        $menu = 'tags';
        return $this->render('index', compact('menu'));
    }
}