<?php
$this->breadcrumbs=array(
	'Results'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('result-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>View Results</h1>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'result-grid',
	'dataProvider' => $model->search(),
	'filter'=>$model,
	'columns'=>array(
		'result_id',
		array(
            'filter' => CHtml::listData(Section::model()->findAll(), 'section_id','title'),
            'name' => 'section_id',
            'value'=>'$data->section->title'
        ),
		array(
            'name'  => 'user_id',
            'value' => '$data->user->name'
        ),
		'passed_at',
		// 'results',
		'total_questions_count',
		/*
		'right_answers_count',
		'wrong_answers_count',*/
		array(
			'name'  => 'right_percent_amount',
			'value' => '$data->right_percent_amount . \'%\'',
		),
		
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{view} {delete}'
		),
	),
)); ?>
