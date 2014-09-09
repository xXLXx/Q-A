<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Answer;
use app\models\Guest;
?>

<?php
    $this->registerCssFile('@web/css/font-awesome.min.css');
    $this->registerCssFile('@web/css/Markdown.Editor.css');
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>
        <div class="wmd-panel">
            <div id="wmd-button-bar" style="padding-bottom: 10px;"></div>
            <?= $form->field($answerModel, 'answer', [
                'inputOptions'  => [
                    'class'         => 'form-control wmd-input',
                    'rows'          => '10',
                    'placeholder'   => 'Enter text ...',
                    'id'            => 'wmd-input'
                ],
                'template'  => "<div class=\"col-lg-12\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>"
            ])->textarea() ?>
        </div>
        <br>
        <div id="wmd-preview" class="well well-content wmd-panel wmd-preview"></div>
        
        <?php if($answerModel->user_group == Answer::USER_GROUP_GUEST): ?>
        <div class="row">
            <div class="col-xs-3">
                <div class="pull-right flat-well">
                    <h4>
                        <?= Html::a('Login', '@web/site/login'); ?>
                        or
                        <?= Html::a('Sign Up', '@web/site/register'); ?>
                    </h4>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="pull-left flat-well col-xs-6">
                    <h4>Post as a Guest</h4>
                    <?= $form->field($guestModel, 'name', [
                        'labelOptions' => ['class' => 'col-xs-2 control-label'],
                        'template'     => "{label}<div class=\"col-xs-10\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>"
                    ]); ?>
                    <?= $form->field($guestModel, 'email', [
                        'labelOptions' => ['class' => 'col-xs-2 control-label'],
                        'template'     => "{label}<div class=\"col-xs-10\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>"
                    ]); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <br>
        <div class="form-group text-right">
            <div class="col-lg-12">
                <?= Html::submitButton('Post this Answer', ['class' => 'btn btn-info', 'name' => 'register-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
    $this->registerJsFile('@web/js/Markdown.Converter.js');
    $this->registerJsFile('@web/js/Markdown.Editor.js');
    $this->registerJsFile('@web/js/Markdown.Sanitizer.js');
    $this->registerJs('
        var converter1 = Markdown.getSanitizingConverter();
        var editor1 = new Markdown.Editor(converter1);
        editor1.run();
        ');
?>