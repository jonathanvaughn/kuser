<?php
$this->breadcrumbs = array(
    KuserModule::t('Users') => array('admin'),
    KuserModule::t('Create'),
);
?>
<h1><?php echo KuserModule::t('Create User'); ?></h1>

<?php
    echo $this->renderPartial('_menu', array(
        'list' => array(),
    ));
    
    echo $this->renderPartial('_form', array('model' => $model));