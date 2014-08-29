<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
    public $rememberMe = true;

    private $_user = false;

    public static function tableName(){
        return '{{%users}}';
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($uniqueName)
    {
        return static::find()
            ->where(['name' => $uniqueName])
            ->orWhere(['email' => $uniqueName])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
    * Register Functions
    */
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'password'], 'required'],
            ['email', 'email'],
            ['name', 'filter', 'filter' => 'ucwords', 'on' => 'register'],
            ['password', 'validatePassword', 'on' => 'login'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [['password_repeat', 'email'], 'required', 'on' => 'register'],
            ['rememberMe', 'boolean'],
            ['rememberMe', 'required', 'on' => 'login'],
            [['name', 'email'], 'unique', 'on' => 'register'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $model = new User([
                'name'      => ucwords($this->name),
                'email'     => $this->email,
                'password'  => Yii::$app->getSecurity()->generatePasswordHash($this->password),
            ]);

            if ($model && $model->save()) {
                Yii::$app->getResponse()->redirect('login');
            } else {
                // Yii::$app->getResponse()->redirect('login');
            }
        }
    }

    /**
    * Login Functions
    */

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->name);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {   
        if (!$this->hasErrors()) {
            $_user = $this->getUser();

            if (!$_user || !Yii::$app->getSecurity()->validatePassword($this->password, $_user->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_at' => 'Account Created',
            'updated_at' => 'Last Update',
        ];
    }

    public function getQuestionsCount(){
        return Question::find()->where(['user_id' => $this->id])->count();
    }

    public function getAnswersCount(){
        return 1;
    }

    public function getTagsCount(){
        return 0;
    }
}
