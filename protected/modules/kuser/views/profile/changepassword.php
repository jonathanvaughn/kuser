<?php $this->pageTitle=Yii::app()->name . ' - '.KuserModule::t("Change Password");
$this->breadcrumbs=array(
	KuserModule::t("Profile") => array('/user/profile'),
	KuserModule::t("Change Password"),
);
?>

<h2><?php echo KuserModule::t("Change password"); ?></h2>
<?php echo $this->renderPartial('menu'); ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo KuserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo KuserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo CHtml::submitButton(KuserModule::t("Save")); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->