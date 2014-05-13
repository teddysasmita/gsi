<?php
/* @var $this DetailstockdamageController */
/* @var $model Detailstockdamage */
/* @var $form CActiveForm */
?> 

<div class="form">

<?php
   
   $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detailstockdamage-form',
	'enableAjaxValidation'=>true,
   ));

$supplierScript=<<<EOS
	$('input,select').keypress(function(event) { return event.keyCode != 13; });

      $('#isAccepted').click(function() {
   		if ($('#isAccepted').prop('checked')) {
   			$('#Detailstockdamage_serialnum').val('Belum Diterima');
   		}
      });
   		
	$('#Detailstockdamage_serialnum').change(function(evt) {
   		var myserialnum = $('#Detailstockdamage_serialnum').val();
   		if (myserialnum !== 'Belum Diterima') {
   			$('#isAccepted').prop('checked', false);
   			$.getJSON('index.php?r=LookUp/CheckSerial', { serialnum: $('#Detailstockdamage_serialnum').val(),
   				idwh: $('#idwh').val() },
   				function(data) {
   					if (data == false) {
   						$('#Detailstockdamage_serialnum_em_').html('Data tidak ditemukan');
						$('#Detailstockdamage_serialnum_em_').prop('style', 'display:block');
   						$('#itemname').removeClass('money');
   						$('#itemname').addClass('error');
   						$('#itemname').html('Barang tidak ditemukan');
   					} else {
   						$('#Detailstockdamage_serialnum_em_').html('');
						$('#Detailstockdamage_serialnum_em_').prop('style', 'display:none');
						$('#Detailstockdamage_iditem').val(data);
   						$.getJSON('index.php?r=LookUp/getItemName2', { id: $('#Detailstockdamage_iditem').val() },
   							function(data2) {
   								$('#itemname').removeClass('error');
   								$('#itemname').addClass('money');
   								$('#itemname').html(data2);
   							});
	   				};
   				});
		}
	});
	
   	$('#myButton').click(
   		function(evt) {
   			var myserialnum = $('#Detailstockdamage_serialnum').val();
   			if (myserialnum !== 'Belum Diterima') {
	   			$.getJSON('index.php?r=LookUp/checkItemSerial', { iditem: $('#Detailstockdamage_iditem').val(), 
	   			serialnum: $('#Detailstockdamage_serialnum').val(), idwh:$('#idwh').val() }, 
	   			function(data) {
	   				if (data=='0') {
	            		$('#Detailstockdamage_serialnum_em_').html('Data tidak ditemukan');
						$('#Detailstockdamage_serialnum_em_').prop('style', 'display:block');
					} else {
						$('#Detailstockdamage_serialnum_em_').html('');
						$('#Detailstockdamage_serialnum_em_').prop('style', 'display:none');
	   					$('#detailstockdamage-form').submit();
	   				};
	   			});
   			} else {
   				$('#Detailstockdamage_serialnum_em_').html('');
				$('#Detailstockdamage_serialnum_em_').prop('style', 'display:none');
   				$('#detailstockdamage-form').submit();
   			}
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
         echo CHtml::hiddenField('idwh',$idwh);
        ?>

	<div class="row">
		<?php echo $form->labelEx($model,'iditem'); ?>
		<?php 
        	echo CHtml::tag('span', array('id'=>'itemname', 'class'=>'error'), false, true);
		?>	
		<?php echo $form->error($model,'iditem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serialnum'); ?>
		<?php echo $form->textField($model,'serialnum'); ?>
		<?php echo $form->error($model,'serialnum'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textArea($model,'remark', array('COLS'=>40, 'ROWS'=>10)); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label('Belum Diterima', false); ?>
		<?php 
			echo CHtml::checkBox('isAccepted', $model->serialnum == 'Belum Diterima'); 
		?>
	</div>
        
	<div class="row buttons">
		<?php echo CHtml::Button($mode, array('id'=>'myButton', 'name'=>'yt0')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->