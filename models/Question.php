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
    public $_tags;
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
            [['question', 'title', '_tags'], 'required', 'on' => 'add'],
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
                if($this->addTags()){
                    return true;
                }
                else{
                    return false;
                }
            } else {
                // Yii::$app->getResponse()->redirect('login');
            }
        }
    }

    public function addTags(){
        foreach (explode(',', $this->_tags) as $key => $value) {
            $questionTag = new QuestionTag();
            $questionTag->link('question', $this);
            
            $tagData = explode(':', $value);
            if($tagData[0] == 0){
                $tag = new Tag();
                $tag->name = $tagData[1];
                if($tag->save()){
                    $questionTag->link('tag', $tag);
                }
                else{
                    return false;
                }
            }
            else{
                $questionTag->tag_id = $tagData[0];
            }

            if(!$questionTag->save()){
                return false;
            }
        }
        return true;
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

    public function getTags(){
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('question_tags', ['question_id' => 'id']);
    }
}
