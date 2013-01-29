<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Questions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'OPERATIONS'),
	array('label'=>'Create Question','icon' => 'plus', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('question-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Questions</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'question-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'question_id',
		array(
            'filter' => CHtml::listData(Section::model()->findAll(), 'section_id','title'),
            'name' => 'section_id',
            'value'=>'$data->section->title'
        ),
		'title',
		'theme',
		array(
            'filter' => $model->getTypeOptions(),
            'name'   => 'type',
            'value'   =>'$data->getTypeOptionValue()',
        ),
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
	),
)); ?>
