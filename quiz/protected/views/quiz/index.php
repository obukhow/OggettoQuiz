<?php
/* @var $this QuizController */

?>
<div id="progress" style="display:none;">
    <div id="bar" style="width:1%;"></div>
    <div id="text-counter" style="display:none;">
        Question <span id="counter-current"><?php echo $number ?></span> of <span id="counter-total"><?php echo $section->getQuestionsCount() ?></span>
    </div>
</div>
<div class="btn-toolbar">
    <div class="btn-group">
<?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'',
        'icon' => 'chevron-left',
        'htmlOptions' => array(
            'onclick' => 'quiz.previous()',
            'id'      => 'prevBtn',
            'encode'  => false,
            'title'   => 'Предыдущий (&larr; + Ctrl)'
        )
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'',
        'icon' => 'chevron-right',
        'htmlOptions' => array(
            'onclick' => 'quiz.next()',
            'id'      => 'nextBtn',
            'encode'  => false,
            'title'   => 'Следующий (Ctrl + &rarr;)'
        )
    ));
?>
</div>
<?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'button',
        'type'=>'inverse',
        'label'=>'Отметить',
        'toggle'=>true,
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Завершить',
        'type'=>'success',
        'htmlOptions' => array(
            'onclick' => 'quiz.finish()',
            'id'      => 'finishBtn',
        )
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Начать',
        'type'=>'success',
        'htmlOptions' => array(
            'onclick' => 'quiz.start()',
            'id'      => 'startBtn',
        )
    ));
?>
</div>
<div class="curtain-container">
    <form id="page-content" action="#">
        <?php if ($question) {
            $this->renderPartial('question', array('question' => $question));
        } else {
            echo $section->description;
        }
        ?>
    </form>
    <div class="curtain" id="curtain"></div>
</div>

<script type="text/javascript">
    window.onload = function(){
        quiz = new OggettoQuiz(<?php echo $section->getQuestionsCount() ?>, <?php echo $number ?>, '<?php echo $section->getUrl() ?>', <?php echo $limit ?>);
    }
</script>