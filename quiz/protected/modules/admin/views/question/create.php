<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs = array(
	'Questions' => array('index'),
	'Create',
);

$this->menu=array(
    array('label' => 'OPERATIONS'),
	array('label' => 'List Questions', 'icon' => 'list', 'url'=>array('index')),
);
?>
<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tmpl.min.js');
?>
<h1>Create Question</h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'answers' => $answers)); ?>