<?php
/* @var $this QuizController */

?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
    You may change the content of this page by modifying
    the file <tt><?php echo __FILE__; ?></tt>.
    <button type="button" onclick="quiz.start();">Start</button>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Start',
        'type'=>'success',
        'htmlOptions' => array(
            'onclick' => 'quiz.start()',
        )
    ));
    ?>
</p>
<script type="text/javascript">
    quiz = new OggettoQuiz(10);
</script>
