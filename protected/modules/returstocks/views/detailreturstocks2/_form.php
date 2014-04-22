<?php
/* @var $this Detailreturstocks2Controller */
/* @var $model Detailreturstocks2 */
/* @var $form CActiveForm */
?> 

<div class="form">

<?php
   
   $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detailreturstocks2-form',
	'enableAjaxValidation'=>true,
   ));

$supplierScript=<<<EOS
	$('input,select').keypress(function(event) { return event.keyCode != 13; });

      $('#isAccepted').click(function() {
   		if ($('#isAccepted').prop('checked')) {
   			$('#Detailreturstocks2_serialnum').val('Belum Diterima');
   		}
      });
   		
	$('#Detailreturstocks2_serialnum').change(function() {
   		var myserialnum = $('#Detailreturstocks2_serialnum').val();
   		if (myserialnum !== 'Belum Diterima')
   			$('#isAccepted').prop('checked', false);
	});
	
   	$('#myButton').click(
   		function(evt) {
   			$.getJSON('index.php?r=LookUp/checkItemSerial', { iditem: $('#Detailreturstocks2_iditem').val(), 
   			serialnum: $('#Detailreturstocks2_serialnum').val(), idwh:$('#idwh').val() }, 
   			function(data) {
   				if (data=='0') {
            		$('#Detailreturstocks2_serialnum_em_').html('Data tidak ditemukan');
					$('#Detailreturstocks2_serialnum_em_').prop('style', 'display:block');
				} else {
					$('#Detailreturstocks2_serialnum_em_').html('');
					$('#Detailreturstocks2_serialnum_em_').prop('style', 'display:none');
   					$('#detailreturstocks2-form').submit();
   				};
   			});
   	});
   		
EOS;
   Yii::app()->clientScript->registerScript("supplierScript", $supplierScript, CClientscript::POS_READY);
   
 ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <?php 
         echo $form->hiddenField($model,'iddetail');
         echo $form->hiddenField($model,'id');
         echo $form->hiddenField($model,'userlog');
         echo $form->hiddenField($model,'datetimelog');
         echo $form->hiddenField($model,'iditem');
         echo $form->hiddenField($model,'serialnum');
        ?>

	<div class="row">
		<?php echo $form->labelEx($model,'iditem'); ?>
		<?php 
               echo CHtml::label(lookup::ItemNameFromItemID($model->iditem), false);
            ?>
		<?php echo $form->error($model,'iditem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serialnum'); ?>
		<?php 
            //echo $form->textField($model,'serialnum'); 
		echo CHtml::label($model->serialnum, false);
        ?>
		<?php echo $form->error($model,'serialnum'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
        <?php 
           echo $form->textArea($model, 'remark', array('COLS'=>40, 'ROWS'=>5)); 
        ?>
        <?php echo $form->error($model,'remark');?> 
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::Button($mode, array('id'=>'myButton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->