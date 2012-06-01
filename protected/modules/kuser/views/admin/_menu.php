<ul class="actions">
<?php
    if ( count($list) )
    {
        foreach ($list as $item)
            echo '<li>' . $item . '</li>';
    }
?>
    <li><?php echo CHtml::link(KuserModule::t('List Users'), 
            array('/kuser')); ?></li>
    <li><?php echo CHtml::link(KuserModule::t('Manage User'), 
            array('admin')); ?></li>
    <li><?php echo CHtml::link(KuserModule::t('Manage Profile Field'),
            array('profileField/admin')); ?></li>
</ul><!-- actions -->