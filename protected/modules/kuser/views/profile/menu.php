<ul class="actions">
<?php 
if(KuserModule::isAdmin()) {
?>
<li><?php echo CHtml::link(KuserModule::t('Manage User'),array('/kuser/admin')); ?></li>
<?php 
} else {
?>
<li><?php echo CHtml::link(KuserModule::t('List User'),array('/kuser')); ?></li>
<?php
}
?>
<li><?php echo CHtml::link(KuserModule::t('Profile'),array('/kuser/profile')); ?></li>
<li><?php echo CHtml::link(KuserModule::t('Edit'),array('edit')); ?></li>
<!--<li><?php //echo CHtml::link(KuserModule::t('Change password'),array('changepassword')); ?></li>-->
<li><?php echo CHtml::link(KuserModule::t('Logout'),array('/kuser/logout')); ?></li>
</ul>