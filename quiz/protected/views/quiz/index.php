<?php
/* @var $this QuizController */

?>
<h1><?php echo $this->id . '/' . $this->action->id ?></h1>

<p>
    You may change the content of this page by modifying
    the file <tt><?php echo __FILE__; ?></tt>.
</p>
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
<script type="text/javascript">
    window.onload = function(){
        quiz = new OggettoQuiz(<?php echo $section->getQuestionsCount() ?>, <?php echo $number ?>, '<?php echo $section->getUrl() ?>');
    }
</script>