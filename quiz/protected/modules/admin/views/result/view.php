<?php
$this->breadcrumbs=array(
	'Results'=>array('index'),
	$model->result_id,
);

$this->menu=array(
	array('label'=>'List Result','url'=>array('index')),
	array('label'=>'Create Result','url'=>array('create')),
	array('label'=>'Update Result','url'=>array('update','id'=>$model->result_id)),
	array('label'=>'Delete Result','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->result_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Result','url'=>array('admin')),
);
?>

<h1>View Result #<?php echo $model->result_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'result_id',
		'section_id',
		'user_id',
		'passed_at',
		'results',
		'total_questions_count',
		'right_answers_count',
		'wrong_answers_count',
		'right_percent_amount',
	),
)); ?>
