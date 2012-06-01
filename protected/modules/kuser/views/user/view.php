<?php
$this->breadcrumbs = array (
    KuserModule::t('Users') => array('index'), $model->username,
);
?>
<h1><?php echo KuserModule::t('View User') . ' "' . $model->username .
        '"'; ?></h1>
<ul class="actions">
    <li><?php echo CHtml::link(KuserModule::t('List Users'), array('index')); ?></li>
</ul><!-- actions -->

<?php

    $attributes = array(
        'username',
    );
    
    array_push($attributes,
        array(
            'name' => 'createtime',
            'value' => date("d.m.Y H:i:s", $model->createtime),
        ),
        array(
            'name' => 'lastvisit',
            'value' => ( ($model->lastvisit) ? date ("d.m.Y H:i:s", 
                    $model->lastvisit) : KuserModule::t('Not visited')),
        )
    );
    
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes,
    ));