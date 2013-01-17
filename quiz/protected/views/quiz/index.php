<?php
/* @var $this QuizController */

?>
<form id="page-content">
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
<script type="text/javascript">
    quiz = new OggettoQuiz(<?php echo $section->getQuestionsCount() ?>, 0, '<?php echo $section->getUrl() ?>');
</script>