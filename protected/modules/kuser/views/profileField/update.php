<?php
$this->breadcrumbs=array(
	KuserModule::t('Profile Fields')=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	KuserModule::t('Update'),
);
?>

<h1><?php echo KuserModule::t('Update ProfileField ').$model->id; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(KuserModule::t('Create Profile Field'),array('create')),
			CHtml::link(KuserModule::t('View Profile Field'),array('view','id'=>$model->id)),
		),
	));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>