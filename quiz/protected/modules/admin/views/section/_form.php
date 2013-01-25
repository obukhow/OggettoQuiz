<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'section-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>
        <?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>255)); ?>
        <?php echo $form->textAreaRow($model,'description',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">

$(document).ready(function() {
    $('#Section_title').change(function() {
        $.get('<?php echo Yii::app()->createUrl('admin/section/sanitizetitle') ?>', {title: $('#Section_title').val()},
            function(data) {
                $('#Section_url').val(data.title);
            })
    });
});
</script>