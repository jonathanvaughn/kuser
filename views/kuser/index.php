<?php
$this->breadcrumbs = array (
    KuserModule::t('Users'),
);
?>
<h1><?php echo KuserModule::t('List Users'); ?></h1>
<?php if (KuserModule::isAdmin())
{
    ?><ul class="actions">
        <li><?php echo CHtml::link(KuserModule::t('Manage User'), 
                Yii::app()->getModule('kuser')->adminUrl); ?></li>
</ul><!-- actions --><?php
} ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'principalname',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->principalname), ' .
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