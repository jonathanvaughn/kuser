<?php
$this->breadcrumbs=array(
	KuserModule::t('Profile Fields')=>array('admin'),
	KuserModule::t('Manage'),
);
?>
<h1><?php echo KuserModule::t('Manage Profile Fields'); ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(KuserModule::t('Create Profile Field'),array('create')),
		),
	));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'varname',
		array(
			'name'=>'title',
			'value'=>'KuserModule::t($data->title)',
		),
		'field_type',
		'field_size',
		//'field_size_min',
		array(
			'name'=>'required',
			'value'=>'ProfileField::itemAlias("required",$data->required)',
		),
		//'match',
		//'range',
		//'error_message',
		//'other_validator',
		//'default',
		'position',
		array(
			'name'=>'visible',
			'value'=>'ProfileField::itemAlias("visible",$data->visible)',
		),
		//*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
