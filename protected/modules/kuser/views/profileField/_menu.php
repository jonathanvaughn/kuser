<ul class="actions">
	<li><?php echo CHtml::link(KuserModule::t('Manage User'),array('/kuser/admin')); ?></li>
	<li><?php echo CHtml::link(KuserModule::t('Manage Profile Field'),array('admin')); ?></li>
<?php 
	if (isset($list)) {
		foreach ($list as $item)
			echo "<li>".$item."</li>";
	}
?>
</ul><!-- actions -->