<?php
/* @var $this DetailstockexitsController */
/* @var $model Detailstockexits */
/* @var $form CActiveForm */
?> 

<div class="form">

<?php
   
   $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detailstockexits-form',
	'enableAjaxValidation'=>true,
   ));

$supplierScript=<<<EOS
	$('input,select').keypress(function(event) { return event.keyCode != 13; });

      $('#isAccepted').click(function() {
   		if ($('#isAccepted').prop('checked')) {
   			$('#Detailstockexits_serialnum').val('Belum Diterima');
   		}
      });
   		
	$('#Detailstockexits_serialnum').change(function() {
   		var myserialnum = $('#Detailstockexits_serialnum').val();
   		if (myserialnum !== 'Belum Diterima')
   			$('#isAccepted').prop('checked', false);
	});
	
   	$('#myButton').click(
   		function(evt) {
   			$.getJSON('index.php?r=LookUp/checkItemSerial', { iditem: $('#Detailstockexits_iditem').val(), 
   			serialnum: $('#Detailstockexits_serialnum').val() }, 
   			function(data) {
   				if (data=='0') {
            		$('#Detailstockexits_serialnum_em_').html('Data tidak ditemukan');
					$('#Detailstockexits_serialnum_em_').prop('style', 'display:block');
   					evt.preventDefault();
				} else {
					$('#Detailstockexits_serialnum_em_').html('');
					$('#Detailstockexits_serialnum_em_').prop('style', 'display:none');
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
		<?php echo $form->textField($model,'serialnum'); ?>
		<?php echo $form->error($model,'serialnum'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label('Belum Diterima', false); ?>
		<?php 
			echo CHtml::checkBox('isAccepted', $model->serialnum == 'Belum Diterima'); 
		?>
	</div>
        
	<div class="row buttons">
		<?php echo CHtml::Button($mode, array('id'=>'myButton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->