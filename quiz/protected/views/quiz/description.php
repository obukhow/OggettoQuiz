<?php
/* @var $this QuizController */
/* @var $question Question */
?>
<h1><?php echo $section->title ?></h1>
<?php $markdown = new CMarkdownParser;
    echo $markdown->safeTransform($section->description);
?>

<?php if ($section->getRelated('themes')): ?>
    <h3>Темы экзамена</h3>
    <ul>
        <?php foreach ($section->getRelated('themes') as $theme): ?>
            <li><?php echo $theme->theme ?></li>   
        <?php endforeach ?>
    </ul>
<?php endif ?>
<h3>Продолжительность</h3>
<?php if ($section->getTimeLimit()): ?>
    Время прохождения теста ограничено и составляет <?php echo $section->time_limit ?> мин.
<?php else: ?>
    Время прохождения теста НЕограничено.
<?php endif ?>
<h3>Дополнительные условия</h3>
<?php if ($section->several_attempts): ?>
    Количество попыток прохождения теста ограничено. Данный тест можно пройти только один раз.
<?php else: ?>
    Количество попыток прохождения теста НЕограничено.
<?php endif ?>