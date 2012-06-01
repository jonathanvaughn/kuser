<?php
$this->breadcrumbs=array(
	KuserModule::t('Profile Fields')=>array('admin'),
	KuserModule::t('Create'),
);
?>
<h1><?php echo KuserModule::t('Create Profile Field'); ?></h1>

<?php echo $this->renderPartial('_menu',array(
		'list'=> array(),
	)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>