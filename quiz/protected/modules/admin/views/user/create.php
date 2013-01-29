<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
    array('label'=>'Operations'),
	array('label'=>'List Users',  'icon' => 'list', 'url'=>array('index')),
    );
?>

<h1>Create User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>