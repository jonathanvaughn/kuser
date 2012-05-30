<?php
$this->breadcrumbs = array(
    KuserModule::t('Users') => array('admin'),
    $model->principalname,
);
?>
<h1><?php echo KuserModule::t('View User') . ' "' . $model->principalname. '"'; 
?></h1>

<?php echo $this->renderPartial('_menu', array(
    'list' => array(
        CHtml::link(KuserModule::t('Create User'), array('create')),
        CHtml::link(KuserModule::t('Update User'), 
                array('update', 'id' => $model->id)),
        CHtml::linkButton(KuserModule::t('Delete User'), array('submit' => 
            array('delete', 'id' => $model->id), 'confirm' => 
            KuserModule::t('Are you sure you want to delete this item?'))),
        ),
    ));

    $attributes = array(
        'id',
        'principalname',
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
                '$model->lastvisit) : KuserModule::t("Not visisted"))',
            ),
            array(
                'name' => 'superuser',
                'value' => Kuser::itemAlias("AdminStatus", $model->superuser),
            ),
            array(
                'name' => 'status',
                'value' => Kuser::itemAlias("UserStatus", $model->status),
            )
    );
    
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes,
    ));