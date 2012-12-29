<?php
$this->breadcrumbs=array(
	'Sections',
);

$this->menu=array(
	array('label'=>'Create Section','url'=>array('create')),
	array('label'=>'Manage Section','url'=>array('admin')),
);
?>

<h1>Sections</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
