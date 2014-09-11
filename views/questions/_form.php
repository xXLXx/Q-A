<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
?>

<?php
	$this->registerCssFile('@web/css/font-awesome.min.css');
	$this->registerCssFile('@web/css/Markdown.Editor.css');
	$this->registerCssFile('@web/css/select2.css');

	$this->registerJsFile('@web/js/Markdown.Converter.js', [], ['position' => View::POS_END]);
	$this->registerJsFile('@web/js/Markdown.Editor.js', [], ['position' => View::POS_END]);
	$this->registerJsFile('@web/js/Markdown.Sanitizer.js', [], ['position' => View::POS_END]);


	$this->registerJsFile('@web/js/select2.js', [Yii::$app->params['appAssetPath']], ['position' => View::POS_END]);
	$this->registerJsFile('@web/js/answers.js', [Yii::$app->params['appAssetPath']], ['position' => View::POS_END]);
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
	    <?= $form->field($model, 'title', [
	    	'template'	=> "{label}\n<div class=\"col-lg-11\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>",
	       	'inputOptions'	=> [
	       		'class'			=> 'form-control',
        		'placeholder'	=> 'What\'s your programming question? Be specific.',
        	],
	    ]) ?>
	    <div class="wmd-panel">
	        <div id="wmd-button-bar" style="padding-bottom: 10px;"></div>
	        <?= $form->field($model, 'question', [
	        	'inputOptions'	=> [
	        		'class'			=> 'form-control wmd-input',
	        		'rows'			=> '10',
	        		'placeholder'	=> 'Enter text ...',
	        		'id'			=> 'wmd-input'
	        	],
	        	'template'	=> "<div class=\"col-lg-12\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>"
	        ])->textarea() ?>
	    </div>
	    <br>
	    <div id="wmd-preview" class="well well-content wmd-panel wmd-preview"></div>

	    <div id="tag-select">
		    <?= $form->field($model, '_tags', [
		    	'template'	=> "<div class=\"col-lg-12\">{input}</div><div class=\"col-lg-12 text-right\">{error}</div>",
		       	'inputOptions'	=> [
		       		'id'			=> 'select2',
		       		'class'			=> '',
	        	],
		    ]) ?>
	    </div>
	    <br>
	    <div class="form-group text-right">
	        <div class="col-lg-12">
	            <?= Html::submitButton('Post this Question', ['class' => 'btn btn-info']) ?>
	        </div>
	    </div>

	    <?php ActiveForm::end(); ?>
	</div>
</div>