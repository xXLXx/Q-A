<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use app\models\Answer;
use app\models\Guest;
use app\models\Comment;
use app\models\Tag;
use app\models\QuestionTag;

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

    /**
    * @param $commentId id of answer to comment to, or 0 for the question itself
    */
    public function actionView($commentsModel = null){
        /**
        * Questions and answer from guest form logged in user
        */
        $model = Question::find()->with(
            [
                'comments',
                'tags' => function($query){
                    $query->select(['id', 'name']);
                }
            ])->where(['id' => Yii::$app->request->getQueryParam('id')])->one();
        
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
            return $this->render('view', compact('model', 'answerModel', 'guestModel', 'commentsModel'));
        }
        
    }

    public function actionComment(){

        $answerId = Yii::$app->request->getQueryParam('answerId');
        /**
        * Comments
        */
        if(Yii::$app->user->isGuest){
            return $this->redirect(($answerId == null ? '../' : '../../').Yii::$app->request->getQueryParam('id'));
        }

        $commentsModel = new Comment();
        $commentsModel->comment_for = ($answerId  == null ?
            Comment::COMMENT_FOR_QUESTION : Comment::COMMENT_FOR_ANSWER);
        $commentsModel->for_id = $commentsModel->comment_for == Comment::COMMENT_FOR_QUESTION ?
            Yii::$app->request->getQueryParam('id') : $answerId;

        if($commentsModel->load(Yii::$app->request->post()) and $commentsModel->add()){
            $return = $commentsModel->comment_for == Comment::COMMENT_FOR_QUESTION ? '../' : '../../';
            return $this->redirect($return.Yii::$app->request->getQueryParam('id'));
        }
        else{
            return $this->actionView($commentsModel);
        }
    }

    public function actionGetTags(){
        Yii::$app->response->format = 'json';
        $q;

        $result = Tag::find()->where('name LIKE "%'.($q = Yii::$app->request->getQueryParam('q')).'%"')->orderBy('name')->all();
        if(!$this->in_array($q, $result, 'name')){
            array_push($result, ['id' => "0", 'name' => $q]);
        }
        return $result;
    }

    private function in_array($needle, $haystack, $field){
        foreach ($haystack as $key => $value) {
            $diff = strcmp(strtolower($needle), $value[$field]);
            if($diff == 0){
                return true;
            }
            else if($diff > 0){
                return false;
            }
        }
        return false;
    }
}