<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	$model->title=>array('view','id'=>$model->section_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tests','url'=>array('index')),
	array('label'=>'Create Test','url'=>array('create')),
	array('label'=>'View Test','url'=>array('view','id'=>$model->section_id)),
	array('label'=>'Manage Test','url'=>array('admin')),
);
?>

<h1>Update Test "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>