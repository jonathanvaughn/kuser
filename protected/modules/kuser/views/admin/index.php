<?php
$this->breadcrumbs = array(
    KUserModule::t('Users') => array('/kuser/user'),
    KUserModule::t('Manage'),
);
?>
<h1><?php echo KUserModule::t('Manage Users'); ?></h1>

<?php echo $this->renderPartial('_menu', array(
    'list' => array(
        CHtml::link(KUserModule::t('Create User'), array('create')),
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
            'name' => 'username',
            'type' => 'raw',
            'value' => 
                'CHtml::link(CHtml::encode($data->username), ' . 
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
                'KUserModule::t("Not visisted"))',
        ),
        array(
            'name' => 'status',
            'value' => 'User::itemAlias("UserStatus", $data->status)',
        ),
        array(
            'name' => 'superuser',
            'value' => 'User::itemAlias("AdminStatus", $data->superuser)',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));