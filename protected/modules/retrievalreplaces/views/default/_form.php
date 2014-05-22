   <?php
/* @var $this RetrievalreplacesController */
/* @var $model Retrievalreplaces */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
   $transScript=<<<EOS
		$('#Retrievalreplaces_transid').change(
		function() {
			$.getJSON('index.php?r=LookUp/getTrans',{ id: $('#Retrievalreplaces_transid').val() },
            function(data) {
				if (data[0].id !== 'NA') {
					$('#Retrievalreplaces_transname').val(data[0].transname);
					$('#transinfo').html(data[0].transinfo);
            		$('#Retrievalreplaces_transinfo').val(data[0].transinfo);
            		$('#command').val('getPO');
					$('#Retrievalreplaces_transinfo_em_').prop('style', 'display:none')
					$('#retrievalreplaces-form').submit();
				} else {
					$('#Retrievalreplaces_transname').val();
					$('#transinfo').html('');
            		$('#Retrievalreplaces_transinfo_em_').html('Data tidak ditemukan');
					$('#Retrievalreplaces_transinfo_em_').prop('style', 'display:block')
				}
			})
		});
		$('.updateButton').click(
		function(evt) {
			$('#command').val('updateDetail');
			$('#detailcommand').val(this.href);
			$('#retrievalreplaces-form').submit();
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
        echo $form->hiddenField($model, 'idwarehouse');
        
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
		<?php echo $form->labelEx($model,'serialnum'); ?>
        <?php 
           echo $form->textField($model, 'serialnum', array('maxlength'=>50)); 
        ?>
        <?php echo $form->error($model,'serialnum');?> 
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'transid'); ?>
        <?php 
        	if ($info == 'Data Pengambilan Barang tidak ditemukan')
           		echo CHtml::tag('div', array('id'=>'mdinfo', 'class'=>'errorMessage'), $info); 
        	else 
        		echo CHtml::tag('div', array('id'=>'mdinfo', 'class'=>'money'), $info);
        ?>
        <?php echo $form->error($model,'transid');?> 
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
      
<?php $this->endWidget(); ?>


      
</div><!-- form -->