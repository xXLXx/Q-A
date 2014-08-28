<?php

namespace app\models;

use Yii;

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
            [['question'], 'required'],
            [['question'], 'string'],
            [['user_id', 'votes', 'created_at', 'updated_at'], 'integer'],
            [['email'], 'string', 'max' => 50]
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
}
