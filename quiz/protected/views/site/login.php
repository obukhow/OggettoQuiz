<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Авторизация';
?>
<br />
<div class="row login-form">

	<div class="span7">
		<h1>Авторизация</h1>
		<?php
		    $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
		?>
	</div>
	<div class="span4">
	</div>
</div><!-- form -->
<br />
