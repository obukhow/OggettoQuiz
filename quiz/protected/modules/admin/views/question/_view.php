<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->question_id), array('view', 'id'=>$data->question_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_id')); ?>:</b>
	<?php echo CHtml::encode($data->section_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('theme')); ?>:</b>
	<?php echo CHtml::encode($data->theme); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />


</div>