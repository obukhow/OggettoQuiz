<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
/* @var $section Section */

$section = new Section();
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                   => 'question-form',
	'enableAjaxValidation' => false,
	'type'                 => 'horizontal',
)); ?>
	<legend>Question</legend>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
			<?php echo $form->dropDownListRow($model,'section_id', CHtml::listData($section->findAll(), 'section_id', 'title')); ?>
			<?php echo $form->textAreaRow($model,'title', array('class'=>'span6', 'rows'=>5)); ?>
			<?php echo $form->checkBoxRow($model,'is_multichoice'); ?>
			<?php echo $form->textFieldRow($model,'theme',array('size'=>60,'maxlength'=>500)); ?>

	</fieldset>
	<legend>Answers</legend>
		<fieldset>
			<?php if ($model->answers()): ?>
				<?php foreach ($model->answers() as $answer): ?>
					<?php $id = $answer->answer_id; ?>
					<label class="control-label" for="<?php echo $id ?>">1</label>
					<div class="controls">
						<input size="60" class="span5" maxlength="500" name="answers[<?php echo $id ?>][title]" id="<?php echo $id ?>" type="text" value="<?php echo $answer->title ?>">
						<input type="hidden" name="answers[<?php echo $id ?>][delete]" id="" value=""/>
						<input name="answers[<?php echo $id ?>][is_correct]" value="1" <?php echo ($answer->is_correct) ? 'checked="checked"' : '' ?> type="checkbox"> Is Correct
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<label class="control-label" for="answer_1">1</label>
				<div class="controls">
					<input size="60" class="span5" maxlength="500" name="answers[val_1][title]" id="answer_1" type="text">
					<input type="hidden" name="answers[val_1][delete]" id="" value=""/>
					<input name="answers[val_1][is_correct]" value="1" type="checkbox"> Is Correct
				</div>

				<label class="control-label" for="answer_2">2</label>
				<div class="controls">
					<input size="60" class="span5" maxlength="500" name="answers[val_2][title]" id="answer_2" type="text">
					<input type="hidden" name="answers[val_2][delete]" id="" value=""/>
					<input name="answers[val_2][is_correct]" value="1" type="checkbox"> Is Correct
				</div>
			<?php endif; ?>
		</fieldset>
	<div class="form-actions">
		<?php if ($model->isNewRecord): ?>
	    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Create')); ?>
	    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Save And Create New')); ?>
	    <?php else: ?>
	    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Save')); ?>
	    <?php endif; ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->