   <?php
/* @var $this ItemcodeprintsController */
/* @var $model Itemcodeprints */
/* @var $form CActiveForm */
?>

<div class="form">


<?php
	$yourscript = <<<EOS
	$('#Itemcodeprints_totalnum').change(function() {
		$('#command').val('setTotalNum');	
		$('#itemcodeprints-form').submit();
	});
EOS;
	Yii::app()->clientScript->registerScript("yourscript", $yourscript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'itemcodeprints-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/itemcodeprint/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'itemcodeprints-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/itemcodeprint/default/update", array('id'=>$model->id))
      ));
  ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
      <?php 
        echo CHtml::hiddenField('command', '', array('id'=>'command'));
        echo $form->hiddenField($model, 'id');
        echo $form->hiddenField($model, 'userlog');
        echo $form->hiddenField($model, 'datetimelog');
        echo $form->hiddenField($model, 'regnum');
      ?>
       
	<div class="row">
		<?php  echo $form->labelEx($model,'idatetime'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Itemcodeprints[idatetime]',
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
           echo $form->dropDownList($model, 'papersize', array('A4'=>'A4', 'A5'=>'A5'), 
			array('empty'=>'Harap Pilih')); 
        ?>
        <?php echo $form->error($model,'papersize');?> 
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
		<?php echo $form->labelEx($model,'barcodetype'); ?>
        <?php 
			echo $form->dropDownList($model, 'barcodetype', array('C128'=>'C128', 
				'C39'=>'C39','C39+'=>'C39+', 'C39E'=>'C39E', 
				'C39E+'=>'C39E+', 'C93'=>'C93'), array('empty'=>'Harap Pilih')); 
        ?>
        <?php echo $form->error($model,'barcodetype');?> 
	</div>

	  
<?php 
	
    if (isset(Yii::app()->session['Detailitemcodeprints'])) {
       $rawdata=Yii::app()->session['Detailitemcodeprints'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailitemcodeprints where id='$model->id'")->queryScalar();
       $sql="select * from detailitemcodeprints where id='$model->id'";
       $rawdata=Yii::app()->db->createCommand($sql)->queryAll ();
    }
    $dataProvider=new CArrayDataProvider($rawdata, array(
          'totalItemCount'=>$count,
    ));
    $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
			array(
				'header'=>'Nama Barang',
				'name'=>'iditem',
				'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])",
			),
            array(
                  'header'=>'Jumlah',
                  'name'=>'num',
              ),
              array(
                  'class'=>'CButtonColumn',
                  'buttons'=> array(
                     'view'=>array(
                        'visible'=>'false'
                     )
                  ),
                  'updateButtonUrl'=>"Action::decodeUpdateDetailItemcodePrintUrl(\$data)",
              		'deleteButtonUrl'=>"Action::decodeDeleteDetailItemcodePrintUrl(\$data)",
              )
          ),
    ));
    
?>

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->