   <?php
/* @var $this PurchasespaymentsController */
/* @var $model Purchasespayments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
	$suppliers=Yii::app()->db->createCommand()
		->select('id, firstname, lastname')
		->from('suppliers')
		->order('firstname, lastname')
		->queryAll();
	foreach($suppliers as $row) {
		$supplierids[]=$row['id'];
		$suppliernames[]=$row['firstname'].' '.$row['lastname'];
	}
	$supplierids=CJSON::encode($supplierids);
	$suppliernames=CJSON::encode($suppliernames);
	$supplierScript=<<<EOS
      var supplierids=$supplierids;
      var suppliernames=$suppliernames;
      $('#Purchasespayments_suppliername').change(function() {
         var activename=$('#Purchasespayments_suppliername').val();
         $('#Purchasespayments_idsupplier').val(
            supplierids[suppliernames.indexOf(activename)]);
      });
   	
      $('#searchUnsettledPO').click(
         function(event) {
            $('#command').val('setSupplier');
            mainform=$('#purchasespayments-form');
            mainform.submit();
            event.preventDefault();
         }
      );   
EOS;
   Yii::app()->clientScript->registerScript("supplierScript", $supplierScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasespayments-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/purchasespayment/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasespayments-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/purchasespayment/default/update", array('id'=>$model->id))
      ));
  ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
      <?php 
        echo CHtml::hiddenField('command', '', array('id'=>'command'));
        echo $form->hiddenField($model, 'id');
        echo $form->hiddenField($model, 'idsupplier');
        echo $form->hiddenField($model, 'userlog');
        echo $form->hiddenField($model, 'datetimelog');
        echo $form->hiddenField($model, 'status');
      ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'regnum'); ?>
		<?php echo $form->textField($model,'regnum',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'regnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idatetime'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Purchasespayments[idatetime]',
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
		<?php echo $form->labelEx($model,'idsupplier'); ?>
		<?php 
         $suppliers=Yii::app()->db->createCommand()
            ->select("id,firstname,lastname")
            ->from("suppliers")
            ->order("firstname, lastname")   
            ->queryAll();
         foreach($suppliers as $row) {
            $suppliername[]=$row['firstname'].' '.$row['lastname'];
         }
         $this->widget("zii.widgets.jui.CJuiAutoComplete", array(
             'name'=>'Purchasespayments_suppliername',
             'source'=>$suppliername,
           'value'=>lookup::SupplierNameFromSupplierID($model->idsupplier)
         ));
         echo CHtml::submitButton('Cari PO', array( 'id'=>'searchUnsettledPO'));   
      ?>
		<?php echo $form->error($model,'idsupplier'); ?>
	</div>
   
   <div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
         <?php 
            echo $form->textArea($model, 'remark', array('rows'=>6, 'cols'=>50));
         ?>
         <?php echo $form->error($model,'remark'); ?>
	</div>
      
<?php 
    if (isset(Yii::app()->session['Detailpurchasespayments'])) {
       $rawdata=Yii::app()->session['Detailpurchasespayments'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailpurchasespayments where id='$model->id'")
            ->queryScalar();
       $sql="select * from detailpurchasespayments where id='$model->id'";
       $rawdata=Yii::app()->db->createCommand($sql)->queryAll ();
    }
    $dataProvider=new CArrayDataProvider($rawdata, array(
          'totalItemCount'=>$count,
    ));
    $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
               	array(
					'header'=>'Nomor PO',
					'name'=>'idpurchaseorder',
					'value'=>"lookup::PurchasesOrderNumFromID(\$data['idpurchaseorder'])"
				),
				array(
					'header'=>'Total',
					'type'=>'number',
					'name'=>'total',
				),
				array(
					'header'=>'Diskon',
					'type'=>'number',
					'name'=>'discount',
				),
				array(
					'header'=>'Terbayar',
					'type'=>'number',
					'name'=>'paid',	
				),
				array(
					'header'=>'Dibayar',
					'type'=>'number',
					'name'=>'amount',
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
                  'updateButtonUrl'=>"Action::decodeUpdateDetailPurchasesPaymentUrl(\$data)",
               )
          ),
    ));
    
?>

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->