<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Question;
use app\models\ContactForm;
use app\models\User;
use yii\data\ActiveDataProvider;
use app\models\Answer;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        // return $this->render('index');
        return $this->actionNewest();
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        $model->scenario = 'login';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', compact('model'));
        }
    }

    public function actionRegister(){
        $model = new User();
        $model->scenario = 'register';
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goBack();
        } else {
            $model->password = '';
            $model->password_repeat = '';
            return $this->render('register', compact('model'));
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionNewest(){
        $menu = 'newest';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->leftJoin('answers', 'question_id = questions.id')
                        ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                        ->groupBy('questions.id')
                        ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionFeatured(){
        $menu = 'featured';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->leftJoin('answers', 'question_id = questions.id')
                        ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                        ->groupBy('questions.id')
                        ->orderBy(['votes' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionFrequent(){
        $menu = 'frequent';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->leftJoin('answers', 'question_id = questions.id')
                        ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                        ->groupBy('questions.id')
                        ->orderBy(['answers_cnt' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionTags(){
        $menu = 'tags';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->orderBy('created_at'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu'));
    }

    public function actionUnanswered(){
        $menu = 'unanswered';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->where([
                            'not in', 
                            'id', Answer::find()->select('question_id')->distinct()
                        ])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }
}
