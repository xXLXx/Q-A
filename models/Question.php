<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\Answer;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property string $question
 * @property string $user_id
 * @property string $email
 * @property integer $votes
 * @property string $created_at
 * @property string $updated_at
 */
class Question extends \yii\db\ActiveRecord
{
    public $answers_cnt = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'title'], 'required', 'on' => 'add'],
            [['question', 'title'], 'string'],
            ['votes', 'default', 'value' => 0],
            ['user_id', 'default', 'value' => Yii::$app->user->identity->id],
            [['user_id', 'votes', 'created_at', 'updated_at'], 'integer'],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'user_id' => 'User ID',
            'email' => 'Email',
            'votes' => 'Votes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function add(){
        if ($this->validate()) {
            if ($this && $this->save()) {
                return true;
            } else {
                // Yii::$app->getResponse()->redirect('login');
            }
        }
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getAnswers(){
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getComments(){
        return $this->hasMany(Comment::className(), ['for_id' => 'id'])->where(['comment_for' => Comment::COMMENT_FOR_QUESTION]);
    }
}
