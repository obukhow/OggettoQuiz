<?php
/* @var $this QuizController */
/* @var $result Result */
?>
<h1><?php if ($result->total_questions_count > 0): ?>
        <?php echo Yii::t('app','Вы набрали {result}%', array('{result}' => round($result->getRightAnswersPercent()))); ?>
    <?php endif; ?>
</h1>

<?php if ($goodThemes): ?>
    <h3>Вы хорошо знаете</h3>
        <ul>
            <?php foreach ($goodThemes as $theme): ?>
                <li><?php printf('%s (%d%%)', $theme->theme, $theme->percent); ?></li>
            <?php endforeach; ?>
        </ul>
<?php endif; ?>
<?php if ($badThemes): ?>
    <h3>Стоит повторить</h3>
        <ul>
            <?php foreach ($badThemes as $theme): ?>
                <li><?php printf('%s (%d%%)', $theme->theme, $theme->percent); ?></li>
            <?php endforeach; ?>
        </ul>
<?php endif; ?>

<h3>Поделитесь результатом</h3>

<!-- AddThis Button BEGIN -->
<div class="social-buttons addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_twitter"></a>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_vk"></a>
<a class="addthis_button_linkedin"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true}; var addthis_share = {'url':'<?php echo $section->getUrl() ?>',
    'title': '<?php echo sprintf('Wow! Я набрал %s%% в тесте «%s»', $result->getRightAnswersPercent(), $section->title) ?>'};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da8b0a321353eda"></script>
<!-- AddThis Button END -->
