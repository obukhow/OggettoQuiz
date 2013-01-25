<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<h2>Тесты</h2>
<ul class="inline-list">
    <?php foreach (Section::model()->findAll() as $section): ?>
        <li><a href="<?php echo $section->getUrl() ?>"><?php echo $section->title ?></a></li>
    <?php endforeach; ?>
</ul>
