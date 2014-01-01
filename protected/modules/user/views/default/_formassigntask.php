   <?php
/* @var $this AuthItemController */
/* @var $model AuthItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'auth-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
      <?php
         echo $form->hiddenfield($model, 'userid', array('value'=>$userid));
      ?>
      
	<div class="row">
		<?php echo $form->labelEx($model,'Select Task'); ?>
		<?php 
               $res=Yii::app()->authdb->createCommand('select name, type, description from AuthItem '.
                  'where type=1')->queryAll();
               $datas=CHtml::listData($res,'name', 'description');
               echo $form->listBox($model,'itemname',$datas, array('size'=>'8')); 
            ?>
		<?php echo $form->error($model,'itemname'); ?>
	</div>

      
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->