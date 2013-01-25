<?php
$this->breadcrumbs=array(
	'Results',
);

$this->menu=array(
	array('label'=>'Create Result','url'=>array('create')),
	array('label'=>'Manage Result','url'=>array('admin')),
);
?>

<h1>Results</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
