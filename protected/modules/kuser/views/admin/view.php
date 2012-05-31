<?php
$this->breadcrumbs = array(
    KUserModule::t('Users') => array('admin'),
    $model->username,
);
?>
<h1><?php echo KUserModule::t('View User') . ' "' . $model->username. '"'; 
?></h1>

<?php echo $this->renderPartial('_menu', array(
    'list' => array(
        CHtml::link(KUserModule::t('Create User'), array('create')),
        CHtml::link(KUserModule::t('Update User'), 
                array('update', 'id' => $model->id)),
        CHtml::linkButton(KUserModule::t('Delete User'), array('submit' => 
            array('delete', 'id' => $model->id), 'confirm' => 
            KUserModule::t('Are you sure you want to delete this item?'))),
        ),
    ));

    $attributes = array(
        'id',
        'username',
    );
    
    array_push($attributes,
            'email',
            array(
                'name' => 'createtime',
                'value' => date("d.m.Y H:i:s", $model->createtime),
            ),
            array(
                'name' => 'lastvisit',
                'value' => '(($model->lastvisit) ? date("d.m.Y H:i:s", ' .
                '$model->lastvisit) : KUserModule::t("Not visisted"))',
            ),
            array(
                'name' => 'superuser',
                'value' => KUser::itemAlias("AdminStatus", $model->superuser),
            ),
            array(
                'name' => 'status',
                'value' => KUser::itemAlias("UserStatus", $model->status),
            )
    );
    
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes,
    ));