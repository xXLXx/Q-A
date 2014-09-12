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
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'questions';
        $dataProvider = new ActiveDataProvider([
            'query'         => Question::find()->leftJoin('answers', 'question_id = questions.id')
                                ->with(['tags' => function($query){
                                    $query->select(['id', 'name']);
                                }])
                                ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                                ->where(['questions.user_id' => Yii::$app->user->identity->id])
                                ->andWhere('questions.title LIKE :filter OR questions.question LIKE :filter',
                                    [':filter' => '%'.$filter.'%'])
                                ->groupBy('questions.id')
                                ->orderBy(['created_at' => SORT_DESC]),
            'pagination'    => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionAnswers(){
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'answers';
        $dataProvider = new ActiveDataProvider([
            'query'         => Answer::find()
                                ->with('question')
                                ->where([
                                    'user_id' => Yii::$app->user->identity->id,
                                    'user_group' => Answer::USER_GROUP_USER
                                    ])
                                ->andWhere('answers.answer LIKE :filter', [':filter' => '%'.$filter.'%'])
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