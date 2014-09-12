<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_votes".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $vote_for
 * @property string $for_id
 */
class UserVote extends \yii\db\ActiveRecord
{
    const VOTE_FOR_ANSWER = 0;
    const VOTE_FOR_QUESTION = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_votes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'vote_for', 'for_id'], 'required'],
            [['user_id', 'vote_for', 'for_id'], 'integer']
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
            'vote_for' => 'Vote For',
            'for_id' => 'For ID',
        ];
    }
}
