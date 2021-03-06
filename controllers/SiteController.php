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
use yii\helpers\Url;
use app\models\Tag;

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

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Url::remember(Url::canonical(), 'lastRequest');
            return true;
        } else {
            return false;
        }
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
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'newest';
        // $question = Question::find()
        //                 ->with(['user' => function($query){
        //                     $query->select('name');
        //                 }, 'answers' => function($query){
        //                     $query->count();
        //                 }])
        //                 ->groupBy('questions.id')
        //                 ->orderBy(['created_at' => SORT_DESC])->all();
        // var_dump($question[0]->answers); exit();
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->leftJoin('answers', 'question_id = questions.id')
                        ->with([
                            'user' => function($query){
                                $query->select(['id', 'name']);
                            },
                            'tags' => function($query){
                                $query->select(['id', 'name']);
                            }
                        ])
                        ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                        ->where('questions.title LIKE :filter OR questions.question LIKE :filter',
                            [':filter' => '%'.$filter.'%'])
                        ->groupBy('questions.id')
                        ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionFeatured(){
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'featured';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()
                        ->leftJoin('answers', 'question_id = questions.id')
                        ->with([
                            'user' => function($query){
                                $query->select(['id', 'name']);
                            },
                            'tags' => function($query){
                                $query->select(['id', 'name']);
                            }
                        ])
                        ->select('COUNT(answers.id) AS answers_cnt, questions.*')
                        ->where('questions.title LIKE :filter OR questions.question LIKE :filter',
                            [':filter' => '%'.$filter.'%'])
                        ->groupBy('questions.id')
                        ->orderBy(['votes' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionFrequent(){
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'frequent';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->leftJoin('answers', 'question_id = questions.id')
                        ->with([
                            'user' => function($query){
                                $query->select(['id', 'name']);
                            },
                            'tags' => function($query){
                                $query->select(['id', 'name']);
                            }
                        ])
                        ->select(['COUNT(answers.id) AS answers_cnt', 'questions.*'])
                        ->where('questions.title LIKE :filter OR questions.question LIKE :filter',
                            [':filter' => '%'.$filter.'%'])
                        ->groupBy('questions.id')
                        ->orderBy(['answers_cnt' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionTags(){
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'tags';
        $dataProvider = new ActiveDataProvider([
            'query' => Tag::find()
                        ->leftJoin('question_tags', 'tag_id = tags.id')
                        ->select(['COUNT(tag_id) AS instance_cnt', 'tags.*'])
                        ->where('tags.name LIKE :filter', [':filter' => '%'.$filter.'%'])
                        ->groupBy('tag_id')
                        ->orderBy(['instance_cnt' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }

    public function actionUnanswered(){
        $filter = Yii::$app->request->getQueryParam('filter') ? Yii::$app->request->getQueryParam('filter') : '';
        $menu = 'unanswered';
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()
                        ->with([
                            'user' => function($query){
                                $query->select(['id', 'name']);
                            },
                            'tags' => function($query){
                                $query->select(['id', 'name']);
                            }
                        ])
                        ->where([
                            'not in', 
                            'id', Answer::find()->select('question_id')->distinct()
                        ])
                        ->andWhere('questions.title LIKE :filter OR questions.question LIKE :filter',
                            [':filter' => '%'.$filter.'%'])
                        ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', compact('menu', 'dataProvider'));
    }
}
