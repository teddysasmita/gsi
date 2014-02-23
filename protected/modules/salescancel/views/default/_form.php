<?php
/* @var $this SalescancelController */
/* @var $model Salescancel */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'salescancel-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php 
       echo $form->hiddenField($model,'id');
       echo $form->hiddenField($model,'userlog');
       echo $form->hiddenField($model,'datetimelog');  
       echo $form->hiddenField($model,'regnum');
       echo CHtml::hiddenField('command');
   ?>
   <div class="row">
		<?php echo $form->labelEx($model,'Tanggal'); ?>
		<?php 
            //echo $form->dateField($model,'idatetime',array('size'=>19,'maxlength'=>19)); 
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
               'name'=>'Salesorders[idatetime]',
                  // additional javascript options for the date picker plugin
               'options'=>array(
                  'showAnim'=>'fold',
                  'dateFormat'=>'yy/mm/dd',
                  'defaultdate'=>$model->idatetime
               ),
               'htmlOptions'=>array(
                  'style'=>'height:20px;',
               ),
               'value'=>$model->idatetime,
            ));
            ?> 
		<?php echo $form->error($model,'idatetime'); ?>
	</div>
   
	<div class="row">
		<?php echo $form->labelEx($model,'invnum'); ?>
		<?php echo $form->textField($model,'invnum',array('size'=>60,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'invnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('cols'=>60,'rows'=>100)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo CHtml::label(number_format($model->total),'false',
                    array('class'=>'money')); 
                  echo $form->hiddenfield($model, 'total');
            ?>
         
		<?php echo $form->error($model,'total'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->