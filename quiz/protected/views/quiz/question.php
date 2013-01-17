<?php
/* @var $this QuizController */
/* @var $question Question */

?>
<h1><?php echo $question->title ?></h1>

<?php foreach ($question->getRelated('answers') as $answer) : ?>
    <input type="radio" name="question[<?php echo $question->question_id ?>]" id="" />
    <label for=""><?php echo $answer->title; ?></label>
<?php endforeach; ?>