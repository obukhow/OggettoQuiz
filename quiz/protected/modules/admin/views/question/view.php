<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label' => 'Operations'),
	array('label'=>'List Questions', 'icon' => 'list', 'url'=>array('index')),
	array('label'=>'Create Question', 'icon' => 'plus', 'url'=>array('create')),
	array('label'=>'Update Question', 'icon' => 'edit', 'url'=>array('update', 'id'=>$model->question_id)),
	array('label'=>'Delete Question', 'icon' => 'trash', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->question_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Question #<?php echo $model->question_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'question_id',
		'section_id',
		'title',
		'theme',
		'type',
	),
)); ?>
