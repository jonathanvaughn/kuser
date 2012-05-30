<div class="form">

<?php echo CHtml::beginForm('', 'post', 
    array('enctype' => 'multiplart/form-data')); ?>
    <p class="note"><?php echo KuserModule::t(
            'Fields with <span class="required">*</span> are required'); ?></p>
    <?php echo CHtml::errorSummary(array($model)); ?>
    
    <div class="row">
        <?php echo CHtml::activeLabelEx($model, 'principalname'); ?>
        <?php echo CHtml::activeTextField($model, 'principalname', 
                array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo CHtml::error($model, 'principalname'); ?>
    </div>        
    <div class="row">
        <?php echo CHtml::activeLabelEx($model, 'email'); ?>
        <?php echo CHtml::activeTextField($model, 'email', 
                array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo CHtml::error($model, 'email'); ?>
    </div>        
    <div class="row">
        <?php echo CHtml::activeLabelEx($model, 'superuser'); ?>
        <?php echo CHtml::activeDropDownList($model, 'superuser', 
                Kuser::itemAlias('AdminStatus')); ?>
        <?php echo CHtml::error($model, 'superuser'); ?>
    </div>        
    <div class="row">
        <?php echo CHtml::activeLabelEx($model, 'status'); ?>
        <?php echo CHtml::activeDropDownList($model, 'status', 
                Kuser::itemAlias('UserStatus')); ?>
        <?php echo CHtml::error($model, 'status'); ?>
    </div>        
    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 
                'Create' : 'Save'); ?>
    </div>
    
<?php echo CHtml::endForm(); ?>
</div><!-- form -->