<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $passwordConfirmation;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'email', 'password', 'passwordConfirmation'], 'required'],
            ['passwordConfirmation', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password != $this->passwordConfirmation) {
                $this->addError($attribute, 'Password Confirmation must be equal to the password.');
            }
        }
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

            // exit();
            if ($model && $model->save()) {
                Yii::$app->getResponse()->redirect('login');
            } else {
                Yii::$app->getResponse()->redirect('login');
            }
        }
    }
}
