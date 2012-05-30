<?php
$this->breadcrumbs = array(
    KuserModule::t('Users') => array('admin'),
    KuserModule::t('Manage'),
);
?>
<h1><?php echo KuserModule::t('Manage Users'); ?></h1>

<?php echo $this->renderPartial('_menu', array(
    'list' => array(
        CHtml::link(KuserModule::t('Create User'), array('create')),
    ),
));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 
                'CHtml::link(CHtml::encode($data->id), array("admin/update", ' .
                '"id" => $data->id))',
        ),
        array(
            'name' => 'principalname',
            'type' => 'raw',
            'value' => 
                'CHtml::link(CHtml::encode($data->principalname), ' . 
                'array("admin/update", "id" => $data->id))',
        ),
        array(
            'name' => 'email',
            'type' => 'raw',
            'value' => 
                'CHtml::link(CHtml::encode($data->email), "mailto:" . $data->email)',
        ),
        array(
            'name' => 'createtime',
            'value' => 'date("d.m.Y H:i:s", $data->createtime)',
        ),
        array(
            'name' => 'lastvisit',
            'value' => 
                '(($data->lastvisit) ? date("d.m.Y H:i:s", $data->lastvisit) : ' . 
                'KuserModule::t("Not visisted"))',
        ),
        array(
            'name' => 'status',
            'value' => 'Kuser::itemAlias("UserStatus", $data->status)',
        ),
        array(
            'name' => 'superuser',
            'value' => 'Kuser::itemAlias("AdminStatus", $data->superuser)',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));