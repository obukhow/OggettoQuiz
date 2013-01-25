<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('result_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->result_id),array('view','id'=>$data->result_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_id')); ?>:</b>
	<?php echo CHtml::encode($data->section_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passed_at')); ?>:</b>
	<?php echo CHtml::encode($data->passed_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('results')); ?>:</b>
	<?php echo CHtml::encode($data->results); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_questions_count')); ?>:</b>
	<?php echo CHtml::encode($data->total_questions_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('right_answers_count')); ?>:</b>
	<?php echo CHtml::encode($data->right_answers_count); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('wrong_answers_count')); ?>:</b>
	<?php echo CHtml::encode($data->wrong_answers_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('right_percent_amount')); ?>:</b>
	<?php echo CHtml::encode($data->right_percent_amount); ?>
	<br />

	*/ ?>

</div>