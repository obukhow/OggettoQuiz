<?php
$this->breadcrumbs=array(
	'Tests',
);

$this->menu=array(
	array('label'=>'Create Test','url'=>array('create')),
	array('label'=>'Manage Test','url'=>array('admin')),
);
?>

<h1>Sections</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
