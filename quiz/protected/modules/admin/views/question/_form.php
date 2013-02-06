<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
/* @var $section Section */

$section = new Section();
$method = ($model->getIsNewRecord())
        ? 'create'
        : 'update';
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                   => 'question-form',
	'enableAjaxValidation' => false,
	'type'                 => 'horizontal',
    'action'               => Yii::app()->createAbsoluteUrl('admin/question/' . $method),
)); ?>
	<legend>Question</legend>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
			<?php echo $form->dropDownListRow($model,'section_id', CHtml::listData($section->findAll(), 'section_id', 'title')); ?>
            <?php echo $form->textFieldRow($model,'title', array('class'=>'span6')); ?>
			<?php echo $form->textAreaRow($model,'text', array('class'=>'span6', 'rows'=>5)); ?>
			<?php echo $form->radioButtonListRow($model, 'type', $model->getTypeOptions()); ?>
			<?php echo $form->textFieldRow($model,'theme',array('size'=>60,'maxlength'=>500)); ?>

	</fieldset>
	<legend>Answers</legend>
		<fieldset id="answers-fieldset">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>'Add',
				    'type' => 'success',
				    'htmlOptions' => array(
				    	'id'   => 'addButton'
				    	),
				)); ?>
		</fieldset>
	<div class="form-actions">
		<?php if ($model->isNewRecord): ?>
	    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Create')); ?>
	    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'type'=>'primary', 'htmlOptions' => array('id' => 'saveAndCreate'), 'label'=>'Save And Create New')); ?>
	    <?php else: ?>
	    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Save')); ?>
	    <?php endif; ?>
	</div>

<?php $this->endWidget(); ?>
<script id="rowTemplate" type="text/x-jquery-tmpl">
	<div id="row_${answer_id}" class="answer-row">
		<label class="control-label" for="${answer_id}">${number}</label>
		<div class="controls">
			<input size="60" class="span5" maxlength="500" name="answers[${answer_id}][title]" value="${title}" type="text">
			<input type="hidden" name="answers[${answer_id}][deleted]" value=""/>
			<input name="answers[${answer_id}][is_correct]" value="1" type="checkbox" {{if is_correct==1}}checked="checked"{{/if}}> Is Correct
			{{if can_delete==1}}<?php $this->widget('bootstrap.widgets.TbButton', array(
				    'label' =>'Delete',
				    'type'  => 'danger',
				    'size'  => 'mini',
				    'htmlOptions' => array(
					    'class' => 'delete-row',
				    	),
				)); ?>{{/if}}
		</div>
	</div>
</script>
<script type="text/javascript">
attributeOption = {
    table : $('#answers-fieldset'),
    template: $('#rowTemplate'),
    itemCount : 1,

    add : function(data) {
    	if (!data) {
    		data = {
    			answer_id : 'val_' + this.itemCount,
    			title : '',
    			is_correct: 0,
    		};
    	}
    	data.number = this.itemCount;
    	data.can_delete = (this.itemCount > 1) ? 1 : 0;
    	this.template.tmpl(data).insertBefore('#addButton');

        this.bindRemoveButtons();
        this.itemCount++;
    },
    remove : function(element){
    	dddd = element;
        var row = $(element).parents('div.answer-row');
        row.hide();
        $(element).prevAll('input[type=hidden]').val(1);
    },
    bindRemoveButtons : function(){
    	self = this;
    	$('.delete-row').click(function() {
				self.remove(this)
    		}
    	);
    },

    addValidationObserver: function() {

    }
    

};
$(document).ready(function() {
	$('#addButton').click(function() {
		attributeOption.add();
	});
    if ($('#saveAndCreate')) {
        $('#saveAndCreate').click(function() {
            $('#question-form').attr('action', function(i, val) {
                return val + '/return/1'
            });
            $('#question-form').submit();
        });
    }
});

<?php if ($model->answers()): ?>
	<?php foreach ($model->answers() as $answer): ?>
		attributeOption.add(<?php echo $answer->toJson() ?>);
	<?php endforeach; ?>
<?php else: ?>
	attributeOption.add();
<?php endif; ?>
</script>
</div><!-- form -->