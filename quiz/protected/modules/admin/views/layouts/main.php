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

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <div id="mainmenu">
        <?php $this->widget('bootstrap.widgets.TbNavbar',array(
            'brand' => 'Labs Admin Panel',
            'items' => array(
                array(
                    'class' =>'bootstrap.widgets.TbMenu',
                    'items' => array(
                        array('label'=>'Quizes', 'url'=>'#', 'items'=> array(
                                array('label' => 'Tests', 'url'=>array('/admin/section')),
                                array('label' => 'Questions', 'url'=>array('/admin/question')),
                                array('label' => 'Results',   'url'=>array('/admin/result')),
                            )),
                        array('label'=>'Users', 'url'=>array('/admin/user/admin')),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    )
                )
            ),
        )); ?>
    </div>
<div class="container" id="page">


    <!-- mainmenu -->
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>
        
    <?php echo $content; ?>

    <div class="clear"></div>


</div><!-- page -->
    <footer class="footer">
        <div class="container">
            &copy; <?php echo date('Y'); ?> Oggetto Web.<br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
        </div><!-- footer -->
    </footer>

</body>
</html>
