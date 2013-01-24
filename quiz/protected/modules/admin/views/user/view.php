<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->user_id)),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User','url'=>array('admin')),
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
		'password',
		'is_oggetto',
	),
)); ?>
<?php if ($model->twitter_id): ?>
    <a href="http://twitter.com/intent/user?user_id=<?php echo $model->twitter_id ?>" target="_blank" />Twitter</a>
<?php endif; ?>
<?php if ($model->facebook_id): ?>
    <a href="http://www.facebook.com/profile.php?id=<?php echo $model->facebook_id ?>" target="_blank" />Facebook</a>
<?php endif; ?>
<?php if ($model->github_id): ?>
    <a href="https://github.com/<?php echo $model->github_id ?>" target="_blank" />Github</a>
<?php endif; ?>
<?php if ($model->google_id): ?>
    <a href="http://profiles.google.com/<?php echo $model->google_id ?>" target="_blank" />Google</a>
<?php endif; ?>
<?php if ($model->linkedin_id): ?>
    <a href="http://www.linkedin.com/profile/view?id=<?php echo $model->linkedin_id ?>" target="_blank" />LinkedIn</a>
<?php endif; ?>
<?php if ($model->vk_id): ?>
    <a href="http://vk.com/id<?php echo $model->vk_id ?>" target="_blank" />VK</a>
<?php endif; ?>
<?php if ($model->yandex_id): ?>
    <a href="<?php echo $model->getYandexUrl() ?>" target="_blank" />Yandex</a>
<?php endif; ?>


