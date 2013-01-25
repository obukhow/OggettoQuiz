<?php
$this->breadcrumbs=array(
	'Results'=>array('index'),
	$model->result_id=>array('view','id'=>$model->result_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Result','url'=>array('admin')),
	array('label'=>'View Result','url'=>array('view','id'=>$model->result_id)),
);
?>

<h1>Update Result <?php echo $model->result_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>