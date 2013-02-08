<?php
$this->breadcrumbs=array(
	'Results'=>array('index'),
	$model->result_id,
);

$this->menu=array(
    array('label'=>'Operations'),
	array('label'=>'List Results',  'icon' => 'list', 'url'=>array('index')),
	array('label'=>'Update Result', 'icon' => 'edit', 'url'=>array('update','id'=>$model->result_id)),
	array('label'=>'Delete Result', 'icon' => 'trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->result_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Result #<?php echo $model->result_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=> $model,
	'attributes'=>array(
		array(
            'name'  => 'user_id',
            'type'  => 'raw',
            'value' => CHtml::link(CHtml::encode($model->user->name),
                                 array('user/view','id'=>$model->user_id)),
        ),
		array(
            'name' => 'section_id',
            'value'=> $model->section->title
        ),
        array(
            'name' => 'passed_at',
            'value'=> Yii::app()->dateFormatter->formatDateTime($model->passed_at, 'long'),
        ),
		'total_questions_count',
		'right_answers_count',
		'wrong_answers_count',
		'right_percent_amount',
	),
)); ?>
<ol>
<?php foreach ($model->section->getRelated('questions') as $question): ?>
	<li class="question">
    <h3><?php echo CHtml::encode($question->title) ?></h3>

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
                        <?php if ($question->isSelectedAnswer($answer, $model->getResult())) echo 'checked="checked"' ?>
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
                        <?php if ($question->isSelectedAnswer($answer, $model->getResult())) echo 'checked="checked"' ?>
                        disabled="disabled"
                        />
                    <label for="question_<?php echo $question->question_id . '_' . $i ?>"><?php echo CHtml::encode($answer->title); ?></label>
                </label>
                <?php endforeach; ?>
        <?php break;
            case $question::TYPE_FREEFORM: ?>
            <pre><?php echo CHtml::encode($question->getAnswerText($model->getResult())) ?></pre>
    <?php endswitch ?>
</li>
<?php endforeach; ?>
</ol>