<?php
/* @var $this QuizController */
/* @var $question Question */
?>
<div id="question">
    <h1><?php echo CHtml::encode($question->title) ?></h1>

    <?php if ($question->text) {
        $markdown = new CMarkdownParser;
        echo $markdown->safeTransform($question->text);
    }
    ?>
    <?php switch ($question->type) :
            case $question::TYPE_ONECHOICE:
            case $question::TYPE_MULTICHOICE: ?>
                <?php $i = 0; foreach ($question->getRelated('answers') as $answer) : ?>
                <label class="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? 'radio' : 'checkbox' ?>">
                    <input type="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? "radio" : 'checkbox' ?>"
                        name="question[<?php echo $question->section_id ?>][<?php echo $question->question_id ?>]<?php echo ($question->type == $question::TYPE_ONECHOICE) ? '' : '[]' ?>"
                        id="question_<?php echo $question->question_id . '_' . ++$i ?>"
                        value="<?php echo $answer->answer_id ?>"
                        />
                    <label for="question_<?php echo $question->question_id . '_' . $i ?>"><?php echo CHtml::encode($answer->title); ?></label>
                </label>
                <?php endforeach; ?>
        <?php break;
            case $question::TYPE_FREEFORM: ?>
            <textarea name="question[<?php echo $question->section_id ?>][<?php echo $question->question_id ?>]" id="question_<?php echo $question->question_id ?>" rows="10" cols="30"></textarea>
    <?php endswitch ?>
</div>