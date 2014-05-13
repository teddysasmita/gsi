   <?php
/* @var $this SendrepairsController */
/* @var $model Sendrepairs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
	$supplierScript=<<<EOS
	$('#Sendrepairs_brandname').change(function(evt) {
		$.getJSON('index.php?r=LookUp/getServiceCenter', {brandname: $('#Sendrepairs_brandname').val()},
		function(data) {
			$('#Sendrepairs_idservicecenter').val(data);
		});
	});
EOS;
	Yii::app()->clientScript->registerScript("supplierScript", $supplierScript, CClientscript::POS_READY);
	
   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sendrepairs-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/sendrepair/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sendrepairs-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/sendrepair/default/update", array('id'=>$model->id))
      ));
  ?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>
        
      <?php 
        echo CHtml::hiddenField('command', '', array('id'=>'command'));
        echo $form->hiddenField($model, 'id');
        echo $form->hiddenField($model, 'idservicecenter');
        echo $form->hiddenField($model, 'userlog');
        echo $form->hiddenField($model, 'regnum');
        echo $form->hiddenField($model, 'datetimelog');
      ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'idatetime'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Sendrepairs[idatetime]',
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
		<?php echo $form->labelEx($model,'brandname'); ?>
		<?php 
         $this->widget("zii.widgets.jui.CJuiAutoComplete", array(
             'name'=>'Sendrepairs[brandname]',
             'sourceUrl'=>Yii::app()->createUrl("LookUp/getBrand"),
           'value'=>$model->brandname,
         ));
      ?>
		<?php echo $form->error($model,'brandname'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'drivername'); ?>
		<?php 
			echo $form->textField($model, 'drivername', array('size'=>50));
		?>
		<?php echo $form->error($model, 'drivername'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'vehicleinfo'); ?>
		<?php 
			echo $form->textField($model, 'vehicleinfo', array('size'=>50));
		?>
		<?php echo $form->error($model, 'vehicleinfo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'duedate'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Sendrepairs[duedate]',
                     // additional javascript options for the date picker plugin
                  'options'=>array(
                     'showAnim'=>'fold',
                     'dateFormat'=>'yy/mm/dd',
                     'defaultdate'=>$model->duedate
                  ),
                  'htmlOptions'=>array(
                     'style'=>'height:20px;',
                  ),
                  'value'=>$model->duedate,
               ));
            ?>
		<?php echo $form->error($model,'duedate'); ?>
	</div>
      
<?php 
    if (isset(Yii::app()->session['Detailsendrepairs'])) {
       $rawdata=Yii::app()->session['Detailsendrepairs'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailsendrepairs where id='$model->id'")->queryScalar();
       $sql="select * from detailsendrepairs where id='$model->id'";
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
                   'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])"
               ),
				array(
                   'header'=>'Qty',
                   'name'=>'qty',
                   'type'=>'number'               
				),
				array(
					'header'=>'Gudang',
					'name'=>'idwarehouse',
					'value'=>"lookup::WarehouseNameFromWarehouseID(\$data['idwarehouse'])"
				),
              array(
                  'class'=>'CButtonColumn',
                  'buttons'=> array(
                      /*'delete'=>array(
                       'visible'=>'false'
                      ),*/
                     'view'=>array(
                        'visible'=>'false'
                     ),
					/*'update'=>array(
						'visible'=>'false'
					)*/
                  ),
					'deleteButtonUrl'=>"Action::decodeDeleteDetailSendRepairUrl(\$data)",
					'updateButtonUrl'=>"Action::decodeUpdateDetailSendRepairUrl(\$data)"
              )
          ),
    ));
    
?>

<?php 
	$rawdata = FALSE;
    if (isset(Yii::app()->session['Detailsendrepairs2'])) {
       $rawdata=Yii::app()->session['Detailsendrepairs2'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailsendrepairs2 where id='$model->id'")->queryScalar();
       $sql="select * from detailsendrepairs2 where id='$model->id'";
       $rawdata=Yii::app()->db->createCommand($sql)->queryAll ();
    }
if (($rawdata !== FALSE) && count($rawdata) > 0) {
	$dataProvider = new CArrayDataProvider ( $rawdata, array (
			'totalItemCount' => $count 
	) );
	$this->widget ( 'zii.widgets.grid.CGridView', array (
			'dataProvider' => $dataProvider,
			'columns' => array (
					array (
							'header' => 'Item Name',
							'name' => 'iditem',
							'value' => "lookup::ItemNameFromItemID(\$data['iditem'])" 
					),
					array (
							'header' => 'Nomor Seri',
							'name' => 'serialnum' 
					),
					array (
							'header' => 'Catatan',
							'name' => 'remark' 
					),
					array (
							'class' => 'CButtonColumn',
							'buttons' => array (
									'delete' => array (
											'visible' => 'false' 
									),
									'view' => array (
											'visible' => 'false' 
									) 
							),
							'updateButtonOptions' => array (
									"class" => 'updateButton' 
							),
							'updateButtonUrl' => "Action::decodeUpdateDetailReturStock2Url(\$data)" 
					) 
			) 
	) );
} else {
	echo "Data nomor serial tidak ditemukan.";
	}
?>

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div>
<!-- form -->