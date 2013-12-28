   <?php
/* @var $this StockentriesController */
/* @var $model Stockentries */
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
      
      $('#searchUndonePO').click(function() {
         var activename=$('#Stockentries_suppliername').val();
         $('#Stockentries_idsupplier').val(
            supplierids[suppliernames.indexOf(activename)]);
         $.getJSON('index.php?r=LookUp/getUndonePO',{ idsupplier: $('#Stockentries_idsupplier').val() },
            function(data) {
               $('#Stockentries_idpurchaseorder').html('');
               var ct=0;
               $('#Stockentries_idpurchaseorder').append(
                  "<option value=''>Harap Pilih</option>"
               );
               while(ct < data.length) {
                  $('#Stockentries_idpurchaseorder').append(
                     '<option value='+data[ct].id+'>'+unescape(data[ct].regnum)+'</option>'
                  );
                  ct++;
               };
            });
      });
      
      $('#Stockentries_idpurchaseorder').change(
         function(event) {
            $('#command').val('setPO');
            mainform=$('#stockentries-form');
            mainform.submit();
            event.preventDefault();
         }
      );   
EOS;
   Yii::app()->clientScript->registerScript("supplierScript", $supplierScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockentries-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/stockentries/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockentries-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/stockentries/default/update", array('id'=>$model->id))
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
        echo $form->hiddenField($model, 'idwarehouse');
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
                  'name'=>'Stockentries[idatetime]',
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
             'name'=>'Stockentries_suppliername',
             'source'=>$suppliername,
           'value'=>lookup::SupplierNameFromSupplierID($model->idsupplier)
         ));
         echo CHtml::Button('Cari PO', array( 'id'=>'searchUndonePO'));   
      ?>
		<?php echo $form->error($model,'idsupplier'); ?>
	</div>

      <div class="row">
		<?php echo $form->labelEx($model,'idpurchaseorder'); ?>
		<?php 
         echo $form->dropDownList($model,'idpurchaseorder',
            array($model->idpurchaseorder=>lookup::PurchasesOrderNumFromID($model->idpurchaseorder)), 
            array('empty'=>'Harap Pilih')); 
      ?>
		<?php echo $form->error($model,'idpurchaseorder'); ?>
	</div>
      
	<div class="row">
		<?php echo $form->labelEx($model,'idwarehouse'); ?>
         <?php 
            echo CHtml::label(lookup::WarehouseNameFromWarehouseID($model->idwarehouse),'false', 
              array('class'=>'money')); 
         ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'vehicleinfo'); ?>
        <?php 
           echo $form->textField($model, 'vehicleinfo'); 
        ?>
        <?php echo $form->error($model,'vehicleinfo');?> 
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
        <?php 
           echo $form->textField($model, 'pic'); 
        ?>
        <?php echo $form->error($model,'pic');?> 
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
        <?php 
           echo $form->textArea($model, 'remark', array('COLS'=>40, 'ROWS'=>5)); 
        ?>
        <?php echo $form->error($model,'remark');?> 
	</div>
	
	
      
<?php 
    if (isset(Yii::app()->session['Detailstockentries'])) {
       $rawdata=Yii::app()->session['Detailstockentries'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailstockentries where id='$model->id'")->queryScalar();
       $sql="select * from detailstockentries where id='$model->id'";
       $rawdata=Yii::app()->db->createCommand($sql)->queryAll ();
    }
    $dataProvider=new CArrayDataProvider($rawdata, array(
          'totalItemCount'=>$count,
    ));
    $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
               array(
                   'header'=>'Item Name',
                   'name'=>'iditem',
                   'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])"
               ),
              array(
                  'header'=>'Nomor Seri',
                  'name'=>'serialnum',
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
                  'updateButtonUrl'=>"Action::decodeUpdateDetailStockEntryUrl(\$data)",
              )
          ),
    ));
    
?>

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->