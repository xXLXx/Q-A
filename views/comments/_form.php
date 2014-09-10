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

<hr>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <div class="col-xs-8 col-xs-offset-1">
        <div class="wmd-panel">
            <div id="wmd-button-bar" style="padding-bottom: 10px;"></div>
            <?= $form->field($commentsModel, 'comment', [
                'inputOptions'  => [
                    'class'         => 'form-control wmd-input',
                    'rows'          => '5',
                    'placeholder'   => 'Enter text ...',
                    'id'            => 'wmd-input'
                ],
                'template'  => "<div class=\"col-lg-12\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>"
            ])->textarea() ?>
        </div>
        <br>
        <div id="wmd-preview" class="well well-content wmd-panel wmd-preview"></div>
        <br>
    </div>
    <div class="col-xs-3">
        <div class="form-group text-center">
            <div class="col-lg-12">
                <?= Html::submitButton('Comment on this', ['class' => 'btn btn-info', 'name' => 'register-button']) ?>
                <?= Html::a('Nevermind', '@web/questions/'.Yii::$app->request->getQueryParam('id'), ['class' => 'btn btn-danger']); ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
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