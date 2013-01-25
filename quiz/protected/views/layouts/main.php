<?php /* @var $this Controller */ ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link href='http://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div class="container" id="page">
		<div class="row">
			<div class="span12">
				<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>" title="<?php echo CHtml::encode(Yii::app()->name); ?>"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/clear_logo.png" class="logo"/></a>
			</div>
		</div>

		<!-- mainmenu -->
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif?>

			
		<?php echo $content; ?>

		<div class="clear"></div>

		<div id="footer" class="row">
			<div class="span8">
				&copy; <?php echo date('Y'); ?> Oggetto Web.<br/>
				All Rights Reserved.<br/>
			</div>
			<div class="span4">
				<?php if (!Yii::app()->user->isGuest): ?>
					<div class="user-avatar" style="<?php if ($url = Yii::app()->user->getState('photo_url')) echo "background-image: url('$url');" ?>">
					</div>
					<div class="user-name">
						<strong><?php echo Yii::app()->user->fullname ?></strong><br/>
						<a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout') ?>">Logout</a>
					</div>
				<?php endif; ?> 
			</div>
		</div><!-- footer -->

	</div><!-- page -->
	<div class="curtain" id="curtain"></div>
</body>
</html>
