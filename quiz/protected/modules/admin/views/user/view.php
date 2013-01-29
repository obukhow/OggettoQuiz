<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Users',  'icon' => 'list', 'url'=>array('admin')),
    array('label'=>'Create User', 'icon' => 'plus', 'url'=>array('create')),
    array('label'=>'Update User', 'icon' => 'edit', 'url'=>array('update','id'=>$model->user_id)),
    array('label'=>'Delete User', 'icon' => 'trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View User #<?php echo $model->user_id; ?></h1>

<img src="<?php echo $model->photo_url; ?>" />
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'name',
		'email',
		array(
                    'label' => 'Role',
                    'value' => User::getRole($model->role)
                ),
		'is_oggetto',
	),
)); ?>
<ul>
<?php if ($model->twitter_id): ?>
    <li>
        <a href="http://twitter.com/intent/user?user_id=<?php echo $model->twitter_id ?>" target="_blank" />Twitter</a>
    </li>
<?php endif; ?>
<?php if ($model->facebook_id): ?>
    <li>
        <a href="http://www.facebook.com/profile.php?id=<?php echo $model->facebook_id ?>" target="_blank" />Facebook</a>
    </li>
<?php endif; ?>
<?php if ($model->github_id): ?>
    <li>
        <a href="https://github.com/<?php echo $model->github_id ?>" target="_blank" />Github</a>
    </li>
<?php endif; ?>
<?php if ($model->google_id): ?>
    <li>
        <a href="http://profiles.google.com/<?php echo $model->google_id ?>" target="_blank" />Google</a>
    </li>
<?php endif; ?>
<?php if ($model->linkedin_id): ?>
    <li>
        <a href="http://www.linkedin.com/profile/view?id=<?php echo $model->linkedin_id ?>" target="_blank" />LinkedIn</a>
    </li>
<?php endif; ?>
<?php if ($model->vk_id): ?>
    <li>
        <a href="http://vk.com/id<?php echo $model->vk_id ?>" target="_blank" />VK</a>
    </li>
<?php endif; ?>
<?php if ($model->yandex_id): ?>
    <li>
        <a href="<?php echo $model->getYandexUrl() ?>" target="_blank" />Yandex</a>
    </li>
<?php endif; ?>
</ul>


<h1>User's Results</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id' => 'result-grid',
    'dataProvider' => $result->searchByUserId($model->user_id),
    'filter' => $result,
    'columns' => array(
        'result_id',
        array(
            'filter' => CHtml::listData(Section::model()->findAll(), 'section_id','title'),
            'name' => 'section_id',
            'value'=>'$data->section->title'
        ),
        array(
            'name'  => 'user_id',
            'value' => '$data->user->name'
        ),
        'passed_at',
        'total_questions_count',
        array(
            'name'  => 'right_percent_amount',
            'value' => '$data->right_percent_amount . \'%\'',
        ),
        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}',
            'buttons' => array(
                    'view' => array(
                        'label' => 'View',
                        'url' => 'Yii::app()->createUrl("/admin/result/view", array("id"  => $data->result_id))',
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'url' => 'Yii::app()->createUrl("/admin/result/delete", array("id"  => $data->result_id))',
                    ),
                ),
            ),
    ),
)); ?>


