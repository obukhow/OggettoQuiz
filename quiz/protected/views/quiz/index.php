<?php
/* @var $this QuizController */

?>

<form id="page-content" action="#">
    <?php if ($question) {
        $this->renderPartial('question', array('question' => $question));
    }
    ?>
</form>
<div class="btn-toolbar">
<?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Start',
        'type'=>'success',
        'htmlOptions' => array(
            'onclick' => 'quiz.start()',
            'id'      => 'startBtn',
        )
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Previous',
        'htmlOptions' => array(
            'onclick' => 'quiz.previous()',
            'id'      => 'prevBtn',
        )
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Next',
        'htmlOptions' => array(
            'onclick' => 'quiz.next()',
            'id'      => 'nextBtn',
        )
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Finish',
        'type'=>'success',
        'htmlOptions' => array(
            'onclick' => 'quiz.finish()',
            'id'      => 'finishBtn',
        )
    ));
?>
</div>
<div id="counter" style="display:none;">
    Question <span id="counter-current"><?php echo $number ?></span> of <span id="counter-total"><?php echo $section->getQuestionsCount() ?></span>
</div>
<script type="text/javascript">
    window.onload = function(){
        quiz = new OggettoQuiz(<?php echo $section->getQuestionsCount() ?>, <?php echo $number ?>, '<?php echo $section->getUrl() ?>');
    }
</script>