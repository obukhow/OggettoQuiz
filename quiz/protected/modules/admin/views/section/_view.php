<?php
/* @var $this SectionController */
/* @var $data Section */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->section_id), array('view', 'id'=>$data->section_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />


</div>