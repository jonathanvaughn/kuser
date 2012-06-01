<?php
$this->breadcrumbs = array (
    KUserModule::t('Users'),
);
?>
<h1><?php echo KUserModule::t('List Users'); ?></h1>
<?php if (KUserModule::isAdmin())
{
    ?><ul class="actions">
        <li><?php echo CHtml::link(KUserModule::t('Manage User'), 
                Yii::app()->getModule('kuser')->adminUrl); ?></li>
        <li><?php echo CHtml::link(KuserModule::t('Manage Profile Field'),
                array('profileField/admin')); ?></li>
</ul><!-- actions --><?php
} ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'username',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->username), ' .
                'array("user/view", "id" => $data->id))',
        ),
        array(
            'name' => 'createtime',
            'value' => 'date("d.m.Y H:i:s", $data->createtime)',
        ),
        array(
            'name' => 'lastvisit',
            'value' => 'date("d.m.Y H:i:s", $data->lastvisit)',
        ),
    ),
));