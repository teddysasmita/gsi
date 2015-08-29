<?php
/* @var $this DetailstockentriesController */
/* @var $model Detailstockentries */
/* @var $form CActiveForm */
?> 

<div class="form">

<?php
   
   $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detailstockentries-form',
	'enableAjaxValidation'=>true,
   ));

$supplierScript=<<<EOS
   		
      $('#isAccepted').click(function() {
   		if ($('#isAccepted').prop('checked')) {
   			$('#Detailstockentries_serialnum').val('Belum Diterima');
   		}
      });
	$('#Detailstockentries_serialnum').change(function() {
   		var myserialnum = $('#Detailstockentries_serialnum').val();
   		var iditem = $('#Detailstockentries_iditem').val();
   		if (myserialnum !== 'Belum Diterima') {
   			$('#isAccepted').prop('checked', false);
   			
   			if( $('#transname').val() == 'AC18') {
				$.getJSON('index.php?r=LookUp/checkSerial', 
					{'serialnum': escape(myserialnum), 
   					'idwh' : $('#idwhsource').val()},
   					function(data) {
   						var message;
   						if (data == 2) {
   							$('#Detailstockentries_status').val("1");	
 							$('#statusinfo').addClass('money');
   							$('#statusinfo').removeClass('errorMessage');
   							$('#statusinfo').html('Bagus');
						} else if (data == 3) {
   							$('#Detailstockentries_status').val("0");	
   							$('#statusinfo').addClass('money');
   							$('#statusinfo').removeClass('errorMessage');
   							$('#statusinfo').html('Rusak');
   						} else if ((data == 4) || (data == 5)) {
   							$('#Detailstockentries_status').val("0");	
   							$('#statusinfo').removeClass('money');
   							$('#statusinfo').addClass('errorMessage');
   							$('#statusinfo').html('Barang belum dikeluarkan dari Gudang Asal');
   						} else if (data == 1) {
   							$('#Detailstockentries_status').val("");	
   							$('#statusinfo').removeClass('money');
   							$('#statusinfo').addClass('errorMessage');
   							$('#statusinfo').html('Barang tidak ada di Gudang Asal');
   						}
					});
			} else {
   				$.getJSON('index.php?r=LookUp/checkSerial2', {'serialnum': escape(myserialnum), 
   						'iditem': escape(iditem)},
   				function(data) {
   					if ((data == 1) || (data == 2)) {
   						$('#statusinfo').addClass('money');
   						$('#statusinfo').removeClass('errorMessage');
   						$('#statusinfo').html('Item bisa diterima');
   						$('#Detailstockentries_status').val('1');
   					} else if (data == 3) {
   						$('#statusinfo').addClass('errorMEssage');
   						$('#statusinfo').removeClass('money');
   						$('#statusinfo').html('Barang dgn nomor seri tsb masih di gudang');
   					} else if ((data == 4) || (data == 5)) {
   						$('#statusinfo').addClass('errorMessage');
   						$('#statusinfo').removeClass('money');
   						$('#statusinfo').html('Barang berbeda telah terdaftar dgn nomor seri tsb');
   					} 
				});
			}
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
        echo CHtml::hiddenField('idwh', $idwh);
        echo CHtml::hiddenField('transname', $transname);
		if ($transname == 'AC18') {
			$idwhsource = Yii::app()->db->createCommand()->select('idwhsource')->from('itemtransfers')
				->where('regnum = :p_regnum', array(':p_regnum'=>$transid))->queryScalar();
			if ($idwhsource !== FALSE)
			echo CHtml::hiddenField('idwhsource', $idwhsource);
		}
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
	
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php 
			if ($transname	== 'AC12') {
				echo $form->dropDownList($model, 'status', 
					array('empty' => 'Harap Pilih','1'=>'Bagus', '0'=>'Rusak' )); 
			} else {
				echo $form->hiddenField($model, 'status');
				echo CHtml::tag('span', array('id'=>'statusinfo'));
			}
		?>
		<?php echo $form->error($model,'status'); ?>
	</div>
        
    <div class="row">
		
		<?php 
			echo CHtml::tag('span', array('id'=>'status', 'class'=>'error'), $error);
		?>		
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($mode); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->