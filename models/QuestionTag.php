<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question_tags".
 *
 * @property string $id
 * @property string $tag_id
 * @property string $question_id
 */
class QuestionTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'question_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'question_id' => 'Question ID',
        ];
    }

    public function getTag(){
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    public function getQuestion(){
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}
