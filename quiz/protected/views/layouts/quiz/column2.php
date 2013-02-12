<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/quiz/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3">
        <div id="sidebar">
        <div id="counter" style="display:none;">
            <div id="counter_item1" class="counter_item">
                <div class="front"></div>
                <div class="digit digit0"></div>
            </div>
            <div id="counter_item2" class="counter_item">
                <div class="front"></div>
                <div class="digit digit0"></div>
            </div>
            <div id="counter_item3" class="counter_item">
                <div class="front"></div>
                <div class="digit digit_colon"></div>
            </div>
            <div id="counter_item4" class="counter_item">
                <div class="front"></div>
                <div class="digit digit0"></div>
            </div>
            <div id="counter_item5" class="counter_item">
                <div class="front"></div>
                <div class="digit digit0"></div>
            </div>
        </div>
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'type'=>'list',
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>