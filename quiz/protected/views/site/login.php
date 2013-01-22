<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>

<div class="row login-form">

	<div class="span7">
		<h1>Login</h1>
		<?php
		    $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
		?>
	</div>
	<div class="span4">
		<div class="form">
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

				<div class="row">
					<?php echo $form->labelEx($model,'username'); ?>
					<?php echo $form->textField($model,'username'); ?>
					<?php echo $form->error($model,'username'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'password'); ?>
					<?php echo $form->passwordField($model,'password'); ?>
					<?php echo $form->error($model,'password'); ?>
				</div>

				<div class="row rememberMe">
					<?php echo $form->checkBox($model,'rememberMe'); ?>
					<?php echo $form->label($model,'rememberMe'); ?>
					<?php echo $form->error($model,'rememberMe'); ?>
				</div>

				<div class="row buttons">
					<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login')); ?>
				</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div><!-- form -->
