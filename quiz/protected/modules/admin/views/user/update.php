<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
    array('label'=>'Operations'),
	array('label'=>'List Users',  'icon' => 'list', 'url'=>array('index')),
	array('label'=>'Create User', 'icon' => 'plus', 'url'=>array('create')),
	array('label'=>'View User',   'icon' => 'eye-open', 'url'=>array('view','id'=>$model->user_id)),
);
?>

<h1>Update User <?php echo $model->user_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>