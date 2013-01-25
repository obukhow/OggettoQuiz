<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'result_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'section_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'passed_at',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'results',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'total_questions_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'right_answers_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'wrong_answers_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'right_percent_amount',array('class'=>'span5','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
