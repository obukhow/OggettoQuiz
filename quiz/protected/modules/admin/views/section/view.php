<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Operations'),
    array('label'=>'Run Test', 'icon' => 'play', 'url' => $model->getUrl(), 'linkOptions' => array('target' => '_blank')),
	array('label'=>'List Tests', 'icon' => 'list', 'url'=>array('index')),
	array('label'=>'Create Test', 'icon' => 'plus', 'url'=>array('create')),
	array('label'=>'Update Test', 'icon' => 'edit', 'url'=>array('update','id'=>$model->section_id)),
	array('label'=>'Delete Test', 'icon' => 'trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->section_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Test "<?php echo $model->title; ?>"</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'section_id',
		'title',
                'url',
                'description'
	),
)); ?>

<ol>
<?php foreach ($model->getRelated('questions') as $question): ?>
	<li class="question">
    <h3><a href="<?php echo $this->createUrl('question/update', array('id' => $question->question_id)) ?>" target="_blank" class="edit-link"><?php echo CHtml::encode($question->title) ?><span>Edit</span></a></h3>

    <?php if ($question->text) {
        $markdown = new CMarkdownParser;
        echo $markdown->safeTransform($question->text);
    }
    ?>
    <?php switch ($question->type) :
            case $question::TYPE_ONECHOICE:
            case $question::TYPE_MULTICHOICE: ?>
               <?php $i = 0; foreach ($question->getRelated('answers') as $answer) : ?>
                <label class="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? 'radio' : 'checkbox' ?> <?php echo ($answer->is_correct) ? "success" : '' ?>">
                    <input type="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? "radio" : 'checkbox' ?>"
                        name="question[<?php echo $question->section_id ?>][<?php echo $question->question_id ?>]<?php echo ($question->type == $question::TYPE_ONECHOICE) ? '' : '[]' ?>"
                        id="question_<?php echo $question->question_id . '_' . ++$i ?>"
                        value="<?php echo $answer->answer_id ?>"
                        disabled="disabled"
                        />
                    <label for="question_<?php echo $question->question_id . '_' . $i ?>"><?php echo CHtml::encode($answer->title); ?></label>
                </label>
                <?php endforeach; ?>
            <?php break; case $question::TYPE_POLL: ?>
                <?php $i = 0; foreach ($question->getRelated('answers') as $answer) : ?>
                <label class="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? 'radio' : 'checkbox' ?>">
                    <input type="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? "radio" : 'checkbox' ?>"
                        name="question[<?php echo $question->section_id ?>][<?php echo $question->question_id ?>]<?php echo ($question->type == $question::TYPE_ONECHOICE) ? '' : '[]' ?>"
                        id="question_<?php echo $question->question_id . '_' . ++$i ?>"
                        value="<?php echo $answer->answer_id ?>"
                        disabled="disabled"
                        />
                    <label for="question_<?php echo $question->question_id . '_' . $i ?>"><?php echo CHtml::encode($answer->title); ?></label>
                </label>
                <?php endforeach; ?>
    <?php endswitch ?>
</li>
<?php endforeach; ?>
</ol>