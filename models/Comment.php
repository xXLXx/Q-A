<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comments".
 *
 * @property string $id
 * @property string $user_id
 * @property string $comment
 * @property string $comment_for
 * @property string $for_id
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends \yii\db\ActiveRecord
{
    const COMMENT_FOR_ANSWER = 0;
    const COMMENT_FOR_QUESTION = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'comment_for', 'for_id', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'required'],
            [['comment'], 'string'],
            ['user_id', 'default', 'value' => Yii::$app->user->identity->id],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'comment_for' => 'Comment For',
            'for_id' => 'For ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function add(){
        if($this->validate()){
            if($this and $this->save()){
                return true;
            }
            else{
                return false;
            }
        }
    }
}
