<?php
/* @var $this QuizController */
/* @var $result Result */
?>
<h1><?php if ($result->total_questions_count > 0): ?>
        <?php echo Yii::t('app','You result is {result}%', array('{result}' => round($result->getRightAnswersPercent()))); ?>
    <?php endif; ?>
</h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
