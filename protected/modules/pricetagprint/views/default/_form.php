   <?php
/* @var $this PricetagprintsController */
/* @var $model Pricetagprints */
/* @var $form CActiveForm */
?>

<div class="form">

<?php


$supplierScript=<<<EOS
      $('#prepare').click(function() {
		$('#command').val('batchcode');
    	$('#pricetagprints-form').submit();  
	});

	$('#Pricetagprints_papersize').change(function() {
		if ( $('#Pricetagprints_papersize').val() == 'F4' ) {
			$('#Pricetagprints_paperwidth').val(21);
			$('#Pricetagprints_paperheight').val(33);
		} else if ( $('#Pricetagprints_papersize').val() == 'A4' ) {
			$('#Pricetagprints_paperwidth').val(21);
			$('#Pricetagprints_paperheight').val(29.7);
		} 
	});
EOS;
Yii::app()->clientScript->registerScript("supplierScript", $supplierScript, CClientscript::POS_READY);
	
	if($command=='create') 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'pricetagprints-form',
			'enableAjaxValidation'=>true,
      		'action'=>Yii::app()->createUrl("/pricetagprint/default/create"),
			'htmlOptions'=>array(
				'enctype'=>'multipart/form-data',
			),
		)
	);
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
		'id'=>'pricetagprints-form',
		'enableAjaxValidation'=>true,
      	'action'=>Yii::app()->createUrl("/pricetagprint/default/update", array('id'=>$model->id)),
      	'htmlOptions'=>array(
      		'enctype'=>'multipart/form-data',
      	),
      ));
  ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
      <?php 
        echo CHtml::hiddenField('command', '', array('id'=>'command'));
        echo CHtml::hiddenField('MAX_FILE_SIZE', '307200', array('id'=>'MAX_FILE_SIZE'));
        echo $form->hiddenField($model, 'id');
        echo $form->hiddenField($model, 'userlog');
        echo $form->hiddenField($model, 'datetimelog');
        echo $form->hiddenField($model, 'regnum');
        echo $form->hiddenField($model, 'bkjpg');
      ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'idatetime'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Pricetagprints[idatetime]',
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
		<?php echo $form->labelEx($model,'papersize'); ?>
        <?php 
           echo $form->dropDownList($model, 'papersize', array('A4'=>'A4', 'F4' => 'F4'), 
			array('empty'=>'Harap Pilih')); 
        ?>
        <?php echo $form->error($model,'papersize');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'paperwidth'); ?>
        <?php 
           echo $form->textField($model, 'paperwidth'); 
        ?>
        <?php echo $form->error($model,'paperwidth');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'paperheight'); ?>
        <?php 
           echo $form->textField($model, 'paperheight'); 
        ?>
        <?php echo $form->error($model,'paperheight');?> 
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model,'labelwidth'); ?>
        <?php 
           echo $form->textField($model, 'labelwidth'); 
        ?>
        <?php echo $form->error($model,'labelwidth');?> 
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'labelheight'); ?>
        <?php 
           echo $form->textField($model, 'labelheight'); 
        ?>
        <?php echo $form->error($model,'labelheight');?> 
	</div>
	
    <div class="row">
		<?php echo $form->LabelEx($model,'itemnamex'); ?>
        <?php 
           echo $form->textField($model, 'itemnamex'); 
        ?>
        <?php echo $form->error($model,'itemnamex');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'itemnamey'); ?>
        <?php 
           echo $form->textField($model, 'itemnamey'); 
        ?>
        <?php echo $form->error($model,'itemnamey');?> 
	</div>
	
	 <div class="row">
		<?php echo $form->LabelEx($model,'itemnamew'); ?>
        <?php 
           echo $form->textField($model, 'itemnamew'); 
        ?>
        <?php echo $form->error($model,'itemnamew');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'itemnameh'); ?>
        <?php 
           echo $form->textField($model, 'itemnameh'); 
        ?>
        <?php echo $form->error($model,'itemnameh');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'itemnamefz'); ?>
        <?php 
           echo $form->textField($model, 'itemnamefz'); 
        ?>
        <?php echo $form->error($model,'itemnamefz');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'itemnameft'); ?>
        <?php 
           echo $form->dropDownList($model, 'itemnameft', 
           		array(
           			'courier'=>'Courier', 
           			'courierB'=>'Courier Bold', 
           			'courierI'=>'Courier Italic', 
           			'courierBI'=>'Courier Bold Italic', 
           			'helvetica'=>'Helvetica', 
           			'helveticaB'=>'Helvetica Bold', 
           			'helveticaI'=>'Helvetica Italic', 
           			'helveticaBI'=>'Helvetica Bold Italic',	 
           			'times'=>'Times',
           			'timesB'=>'Times Bold',
           			'timesI'=>'Times Italic',
           			'timesBI'=>'Times Bold Italic',
           )); 
        ?>
        <?php echo $form->error($model,'itemnameft');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'itemnamec'); ?>
        <?php 
           echo $form->textField($model, 'itemnamec'); 
        ?>
        <?php echo $form->error($model,'itemnamec');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'pricex'); ?>
        <?php 
           echo $form->textField($model, 'pricex'); 
        ?>
        <?php echo $form->error($model,'pricex');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'pricey'); ?>
        <?php 
           echo $form->textField($model, 'pricey'); 
        ?>
        <?php echo $form->error($model,'pricey');?> 
	</div>
	
	 <div class="row">
		<?php echo $form->LabelEx($model,'pricew'); ?>
        <?php 
           echo $form->textField($model, 'pricew'); 
        ?>
        <?php echo $form->error($model,'pricew');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'priceh'); ?>
        <?php 
           echo $form->textField($model, 'priceh'); 
        ?>
        <?php echo $form->error($model,'priceh');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'pricefz'); ?>
        <?php 
           echo $form->textField($model, 'pricefz'); 
        ?>
        <?php echo $form->error($model,'pricefz');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'priceft'); ?>
        <?php 
           echo $form->dropDownList($model, 'priceft', 
           		array(
           			'courier'=>'Courier', 
           			'courierB'=>'Courier Bold', 
           			'courierI'=>'Courier Italic', 
           			'courierBI'=>'Courier Bold Italic', 
           			'helvetica'=>'Helvetica', 
           			'helveticaB'=>'Helvetica Bold', 
           			'helveticaI'=>'Helvetica Italic', 
           			'helveticaBI'=>'Helvetica Bold Italic',	 
           			'times'=>'Times',
           			'timesB'=>'Times Bold',
           			'timesI'=>'Times Italic',
           			'timesBI'=>'Times Bold Italic',
           )); 
        ?>
        <?php echo $form->error($model,'priceft');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'pricec'); ?>
        <?php 
           echo $form->textField($model, 'pricec'); 
        ?>
        <?php echo $form->error($model,'pricec');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'withextra'); ?>
        <?php 
           echo $form->dropDownList($model, 'withextra', 
           		array('1'=>'Ya', '0'=>'Tidak'
           )); 
        ?>
        <?php echo $form->error($model,'withextra');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'extrax'); ?>
        <?php 
           echo $form->textField($model, 'extrax'); 
        ?>
        <?php echo $form->error($model,'extrax');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'extray'); ?>
        <?php 
           echo $form->textField($model, 'extray'); 
        ?>
        <?php echo $form->error($model,'extray');?> 
	</div>
	
	 <div class="row">
		<?php echo $form->LabelEx($model,'extraw'); ?>
        <?php 
           echo $form->textField($model, 'extraw'); 
        ?>
        <?php echo $form->error($model,'extraw');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'extrah'); ?>
        <?php 
           echo $form->textField($model, 'extrah'); 
        ?>
        <?php echo $form->error($model,'extrah');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'extrafz'); ?>
        <?php 
           echo $form->textField($model, 'extrafz'); 
        ?>
        <?php echo $form->error($model,'extrafz');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'extraft'); ?>
        <?php 
           echo $form->dropDownList($model, 'extraft', 
           		array(
           			'courier'=>'Courier', 
           			'courierB'=>'Courier Bold', 
           			'courierI'=>'Courier Italic', 
           			'courierBI'=>'Courier Bold Italic', 
           			'helvetica'=>'Helvetica', 
           			'helveticaB'=>'Helvetica Bold', 
           			'helveticaI'=>'Helvetica Italic', 
           			'helveticaBI'=>'Helvetica Bold Italic',	 
           			'times'=>'Times',
           			'timesB'=>'Times Bold',
           			'timesI'=>'Times Italic',
           			'timesBI'=>'Times Bold Italic',
           )); 
        ?>
        <?php echo $form->error($model,'extraft');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'extrac'); ?>
        <?php 
           echo $form->textField($model, 'extrac'); 
        ?>
        <?php echo $form->error($model,'extrac');?> 
	</div>

	<div class="row">
		<?php echo $form->LabelEx($model,'withcode'); ?>
        <?php 
           echo $form->dropDownList($model, 'withcode', 
           		array('1'=>'Ya', '0'=>'Tidak'
           )); 
        ?>
        <?php echo $form->error($model,'withcode');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'codex'); ?>
        <?php 
           echo $form->textField($model, 'codex'); 
        ?>
        <?php echo $form->error($model,'codex');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'codey'); ?>
        <?php 
           echo $form->textField($model, 'codey'); 
        ?>
        <?php echo $form->error($model,'codey');?> 
	</div>
	
	 <div class="row">
		<?php echo $form->LabelEx($model,'codew'); ?>
        <?php 
           echo $form->textField($model, 'codew'); 
        ?>
        <?php echo $form->error($model,'codew');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'codeh'); ?>
        <?php 
           echo $form->textField($model, 'codeh'); 
        ?>
        <?php echo $form->error($model,'codeh');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'codefz'); ?>
        <?php 
           echo $form->textField($model, 'codefz'); 
        ?>
        <?php echo $form->error($model,'codefz');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'codeft'); ?>
        <?php 
           echo $form->dropDownList($model, 'codeft', 
           		array(
           			'courier'=>'Courier', 
           			'courierB'=>'Courier Bold', 
           			'courierI'=>'Courier Italic', 
           			'courierBI'=>'Courier Bold Italic', 
           			'helvetica'=>'Helvetica', 
           			'helveticaB'=>'Helvetica Bold', 
           			'helveticaI'=>'Helvetica Italic', 
           			'helveticaBI'=>'Helvetica Bold Italic',	 
           			'times'=>'Times',
           			'timesB'=>'Times Bold',
           			'timesI'=>'Times Italic',
           			'timesBI'=>'Times Bold Italic',
           )); 
        ?>
        <?php echo $form->error($model,'codeft');?> 
	</div>
	
	<div class="row">
		<?php echo $form->LabelEx($model,'codec'); ?>
        <?php 
           echo $form->textField($model, 'codec'); 
        ?>
        <?php echo $form->error($model,'codec');?> 
	</div>
		
<?php 
    if (isset(Yii::app()->session['Detailpricetagprints'])) {
       $rawdata=Yii::app()->session['Detailpricetagprints'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailpricetagprints where id='$model->id'")->queryScalar();
       $sql="select * from detailpricetagprints where id='$model->id'";
       $rawdata=Yii::app()->db->createCommand($sql)->queryAll ();
    }
    $dataProvider=new CArrayDataProvider($rawdata, array(
          'totalItemCount'=>$count,
    ));
    $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
              array(
                  'header'=>'Jenis Barang',
                  'name'=>'iditem',
              		'value' => "lookup::ItemNameFromItemID(\$data['iditem'])",
              ),
            	array(
            		'header'=>'Kode',
            		'name'=>'iditem',
            		'value' => "lookup::ItemCodeFromItemID(\$data['iditem'])",
            	),
            	array(
            		'name'=>'qty',
            		'type'=>'number',
    			),
              array(
                  'class'=>'CButtonColumn',
                  'buttons'=> array(
                      'delete'=>array(
                       'visible'=>'false'
                      ),
                     'view'=>array(
                        'visible'=>'false'
                     )
                  ),
                  'updateButtonUrl'=>"Action::decodeUpdateDetailPricetagPrintUrl(\$data)",
              )
          ),
    ));
    
?>

	<div class="row">
		<?php echo $form->LabelEx($model,'bkjpg'); ?>
        <?php 
           echo $form->fileField($model, 'bkjpg'); 
        ?>
        <?php echo $form->error($model,'bkjpg');?> 
	</div>
	
   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->