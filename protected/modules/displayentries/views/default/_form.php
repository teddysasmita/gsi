   <?php
/* @var $this StockentriesController */
/* @var $model Stockentries */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
   $transScript=<<<EOS
		$('#Stockentries_transid').change(
		function() {
			$.getJSON('index.php?r=LookUp/getTrans',{ id: $('#Stockentries_transid').val() },
            function(data) {
				if (data[0].id !== 'NA') {
					$('#Stockentries_transname').val(data[0].transname);
					$('#transinfo').html(data[0].transinfo);
            		$('#Stockentries_transinfo').val(data[0].transinfo);
            		$('#command').val('getPO');
					$('#Stockentries_transinfo_em_').prop('style', 'display:none')
					$('#stockentries-form').submit();
				} else {
					$('#Stockentries_transname').val();
					$('#transinfo').html('');
            		$('#Stockentries_transinfo_em_').html('Data tidak ditemukan');
					$('#Stockentries_transinfo_em_').prop('style', 'display:block')
				}
			})
		});
		$('.updateButton').click(
		function(evt) {
			$('#command').val('updateDetail');
			$('#detailcommand').val(this.href);
			$('#stockentries-form').submit();
		});   
EOS;
   Yii::app()->clientScript->registerScript("transScript", $transScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockentries-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/displayentries/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockentries-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/displayentries/default/update", array('id'=>$model->id))
      ));
  ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
      <?php 
        echo CHtml::hiddenField('command', '', array('id'=>'command'));
        echo CHtml::hiddenField('detailcommand', '', array('id'=>'detailcommand'));
        echo $form->hiddenField($model, 'id');
        echo $form->hiddenField($model, 'userlog');
        echo $form->hiddenField($model, 'datetimelog');
        echo $form->hiddenField($model, 'regnum');
        echo $form->hiddenField($model, 'transid');
      ?>
        
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
        	if ($info == 'Barang tidak ditemukan')
           		echo CHtml::tag('div', array('id'=>'mdinfo', 'class'=>'errorMessage'), $info); 
        	else 
        		echo CHtml::tag('div', array('id'=>'mdinfo', 'class'=>'money'), $info);
        ?>
        <?php echo $form->error($model,'transid');?> 
	</div>
      
<?php $this->endWidget(); ?>


      
</div><!-- form -->