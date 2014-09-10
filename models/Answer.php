<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "answers".
 *
 * @property string $id
 * @property string $answer
 * @property string $name
 * @property string $email
 * @property integer $votes
 * @property string $question_id
 * @property string $created_at
 * @property string $updated_at
 */
class Answer extends \yii\db\ActiveRecord
{
    const USER_GROUP_GUEST = 0;
    const USER_GROUP_USER = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer', 'user_id', 'user_group'], 'required'],
            [['answer'], 'string'],
            [['votes', 'created_at', 'updated_at', 'question_id', 'user_group', 'user_id'], 'integer'],
            ['question_id', 'default', 'value' => Yii::$app->request->getQueryParam('id')],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer' => 'Answer',
            'user_group' => 'User Type',
            'user_id' => 'User ID',
            'votes' => 'Votes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'question_id' => 'Question ID',
        ];
    }

    public function getQuestion(){
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function getGuest(){
        return $this->hasOne(Guest::className(), ['id' => 'user_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getComments(){
        return $this->hasMany(Comment::className(), ['for_id' => 'id'])->where(['comment_for' => Comment::COMMENT_FOR_ANSWER]);
    }

    public function add($guestModel){
        if($this->user_group == static::USER_GROUP_USER){
            $this->user_id = Yii::$app->user->identity->id;
        }
        else{
            if($guestModel->save()){
                $this->link('guest', $guestModel);
            }
            else{
                return false;
            }
        }
        if($this->validate()){
            if($this and $this->save()){
                return true;
            }
            else{
                return false;
            }
        }
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }
}
