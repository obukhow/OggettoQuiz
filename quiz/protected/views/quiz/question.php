<?php
/* @var $this QuizController */
/* @var $question Question */

?>
<div id="question">
    <h1><?php echo $question->title ?></h1>
    <?php switch ($question->type) :
            case $question::TYPE_ONECHOICE:
            case $question::TYPE_MULTICHOICE: ?>
                <?php $i = 0; foreach ($question->getRelated('answers') as $answer) : ?>
                    <input type="<?php echo ($question->type == $question::TYPE_ONECHOICE) ? "radio" : "checkbox" ?>"
                        name="question[<?php echo $question->question_id ?>]"
                        id="question_<?php echo $question->question_id . '_' . ++$i ?>"
                        value="<?php echo $i ?>"
                        />
                    <label for="question_<?php echo $question->question_id . '_' . $i ?>"><?php echo $answer->title; ?></label>
                <?php endforeach; ?>
        <?php break;
            case $question::TYPE_FREEFORM: ?>
            <textarea name="question[<?php echo $question->question_id ?>]" id="question_<?php echo $question->question_id ?>" rows="10" cols="30"></textarea>
    <?php endswitch ?>
</div>