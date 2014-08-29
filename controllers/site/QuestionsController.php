<?php

namespace app\controllers\site;

use Yii;
use app\models\Question;

class QuestionsController extends \app\controllers\SiteController
{
	public function actionAdd()
    {
    	if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Question();
        $model->scenario = 'add';
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->goBack();
        } else {
            return $this->render('add', compact('model'));
        }
    }
}