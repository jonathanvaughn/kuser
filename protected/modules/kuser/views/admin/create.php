<?php
$this->breadcrumbs = array(
    KUserModule::t('Users') => array('admin'),
    KUserModule::t('Create'),
);
?>
<h1><?php echo KUserModule::t('Create User'); ?></h1>

<?php
    echo $this->renderPartial('_menu', array(
        'list' => array(),
    ));
    
    echo $this->renderPartial('_form', array('model' => $model));