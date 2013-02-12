<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	$model->title=>array('view','id'=>$model->section_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Operations'),
	array('label'=>'List Tests', 'icon' => 'list', 'url'=>array('index')),
	array('label'=>'Create Test', 'icon' => 'plus', 'url'=>array('create')),
	array('label'=>'View Test', 'icon' => 'eye-open', 'url'=>array('view','id'=>$model->section_id)),
);
?>

<h1>Update Test "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>