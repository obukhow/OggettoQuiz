<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->title=>array('view','id'=>$model->question_id),
	'Update',
);

$this->menu=array(
    array('label'=>'OPERATIONS'),
	array('label'=>'List Questions', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>'Create Question', 'icon'=>'plus', 'url'=>array('create')),
	array('label'=>'View Question', 'icon'=>'eye-open', 'url'=>array('view', 'id'=>$model->question_id)),
);
?>

<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tmpl.min.js');
?>

<h1>Update Question <?php echo $model->question_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'answers' => $answers)); ?>