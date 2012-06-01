<?php
$this->breadcrumbs = array(
    KUserModule::t('Users') => array('admin'),
    $model->username = array('view', 'id' => $model->id),
    KUserModule::t('Update'),
);
?>

<h1><?php echo KUserModule::t('Update User') . " " . $model->id; ?></h1>

<?php echo $this->renderPartial('_menu', array(
    'list' => array(
        CHtml::link(KUserModule::t('Create User'), array('create')),
        CHtml::link(KUserModule::t('View User'), array('view', 'id' => $model->id)),
        ),
    ));
    
    echo $this->renderPartial('_form', array('model' => $model, 
        'profile' => $profile));