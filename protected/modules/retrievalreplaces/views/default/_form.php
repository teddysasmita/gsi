   <?php
/* @var $this RetrievalreplacesController */
/* @var $model Retrievalreplaces */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
   $transScript=<<<EOS
		$('#Retrievalreplaces_serialnum').change(
		function() {
			$.getJSON('index.php?r=LookUp/checkRetrieval',{ invnum: $('#Retrievalreplaces_invnum').val(),
				serialnum: $('#Retrievalreplaces_serialnum').val() },
            function(data) {
				if (data.length > 0 ) {
					$('#validData').val('true');
					$('#Retrievalreplaces_iditem').val(data[0].iditem);
					$('#mdinfo').addClass('money');
					$('#mdinfo').removeClass('errorMessage');
					$('#mdinfo').html('Nomor Faktur dan Nomor seri valid');
				} else {
					$('#validData').val('false');
					$('#mdinfo').addClass('errorMessage');
					$('#mdinfo').removeClass('money');
					$('#mdinfo').html('Nomor Faktur dan/atau Nomor seri TIDAK valid');
				}
			})
		});
EOS;
   Yii::app()->clientScript->registerScript("transScript", $transScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retrievalreplaces-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/retrievalreplaces/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retrievalreplaces-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/retrievalreplaces/default/update", array('id'=>$model->id))
      ));
  ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
      <?php 
        echo CHtml::hiddenField('command', '', array('id'=>'command'));
        echo CHtml::hiddenField('detailcommand', '', array('id'=>'detailcommand'));
        echo CHtml::hiddenField('validData', 'false');
        echo $form->hiddenField($model, 'idwarehouse');
        echo $form->hiddenField($model, 'regnum');
        echo $form->hiddenField($model, 'idatetime');
        echo $form->hiddenField($model, 'userlog');
        echo $form->hiddenField($model, 'datetimelog');
        echo $form->hiddenField($model, 'iditem');
        echo $form->hiddenField($model, 'id');
      ?>
     
    <div class="row">
		<?php echo $form->labelEx($model,'idwarehouse'); ?>
        <?php 
           echo CHtml::tag('span',array('class'=>'money'),
			lookup::WarehouseNameFromWarehouseID($model->idwarehouse)); 
        ?>
        <?php echo $form->error($model,'idwarehouse');?> 
	</div>
	 
    <div class="row">
		<?php echo $form->labelEx($model,'invnum'); ?>
        <?php 
           echo $form->textField($model, 'invnum', array('maxlength'=>12)); 
        ?>
        <?php echo $form->error($model,'invnum');?> 
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'serialnum'); ?>
        <?php 
           echo $form->textField($model, 'serialnum', array('maxlength'=>50)); 
        ?>
        <?php echo $form->error($model,'serialnum');?> 
	</div>
	
	<div class="row">
		<?php echo CHtml::label('Status',false); ?>
        <?php 
           	echo CHtml::tag('span', array('id'=>'mdinfo'), $info); 
        ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'idwhsource'); ?>
		<?php
			$data=Yii::app()->db->createCommand()->select('id,code')->from('warehouses')->queryAll();
			$data=CHtml::listData($data, 'id', 'code'); 
			echo $form->dropDownList($model, 'idwhsource', $data, array('empty'=>'Harap Pilih')); 
		?>
		<?php echo $form->error($model,'idwhsource'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::submitButton(ucfirst($command)); ?>
	</div>
      
<?php $this->endWidget(); ?>


      
</div><!-- form -->