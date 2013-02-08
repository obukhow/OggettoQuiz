<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'OPERATIONS'),
	array('label'=>'Create Test','icon'=>'plus', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('section-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tests</h1>

<!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'section-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'section_id',
		'title',
		array(
			'filter'  => false,
            'name'   => 'questions',
            'value'   =>'count($data->questions)',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
