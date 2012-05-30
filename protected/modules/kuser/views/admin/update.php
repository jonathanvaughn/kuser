<?php
$this->breadcrumbs = array(
    KuserModule::t('Users') => array('admin'),
    $model->principalname = array('view', 'id' => $model->id),
    KuserModule::t('Update'),
);
?>

<h1><?php echo KuserModule::t('Update User') . " " . $model->id; ?></h1>

<?php echo $this->renderPartial('_menu', array(
    'list' => array(
        CHtml::link(KuserModule::t('Create User'), array('create')),
        CHtml::link(KuserModule::t('View User'), array('view', 'id' => $model->id)),
        ),
    ));
    
    echo $this->renderPartial('_form', array('model' => $model));