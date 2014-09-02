<?php

namespace app\models;

use Yii;

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
            [['answer', 'name', 'question_id'], 'required'],
            [['answer'], 'string'],
            [['votes', 'created_at', 'updated_at', 'question_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'email' => 'Email',
            'votes' => 'Votes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'question_id' => 'Question ID',
        ];
    }
}
