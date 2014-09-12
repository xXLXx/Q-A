<?php

namespace app\models;

use Yii;
use app\models\QuestionTag;

/**
 * This is the model class for table "tags".
 *
 * @property string $id
 * @property string $name
 */
class Tag extends \yii\db\ActiveRecord
{
    public $instance_cnt = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getQuestionTags(){
        return $this->hasMany(QuestionTag::className(), ['tag_id' => 'id']);
    }
}
