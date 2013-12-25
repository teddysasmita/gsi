   <?php
/* @var $this PurchasesmemosController */
/* @var $model Purchasesmemos */
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
      
      $('#searchUnsettledPO').click(function() {
         var activename=$('#Purchasesmemos_suppliername').val();
         $('#Purchasesmemos_idsupplier').val(
            supplierids[suppliernames.indexOf(activename)]);
         $.getJSON('index.php?r=LookUp/getUnsettledPO',{ idsupplier: $('#Purchasesmemos_idsupplier').val() },
            function(data) {
               $('#Purchasesmemos_idpurchaseorder').html('');
               var ct=0;
               $('#Purchasesmemos_idpurchaseorder').append(
                  "<option value=''>Harap Pilih</option>"
               );
               while(ct < data.length) {
                  if (data[ct].id !== '') {
                     $('#Purchasesmemos_idpurchaseorder').append(
                        '<option value='+data[ct].id+'>'+unescape(data[ct].regnum)+'</option>'
                     );
                  };
                  ct++;
               };
            });
      });
      
      $('#Purchasesmemos_idpurchaseorder').change(
         function(event) {
            $('#command').val('setPO');
            mainform=$('#purchasesmemos-form');
            mainform.submit();
            event.preventDefault();
         }
      );   
EOS;
   Yii::app()->clientScript->registerScript("supplierScript", $supplierScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasesmemos-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/purchasesmemo/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasesmemos-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/purchasesmemo/default/update", array('id'=>$model->id))
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
                  'name'=>'Purchasesmemos[idatetime]',
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
             'name'=>'Purchasesmemos_suppliername',
             'source'=>$suppliername,
           'value'=>lookup::SupplierNameFromSupplierID($model->idsupplier)
         ));
         echo CHtml::Button('Cari PO', array( 'id'=>'searchUnsettledPO'));   
      ?>
		<?php echo $form->error($model,'idsupplier'); ?>
	</div>

   <div class="row">
		<?php echo $form->labelEx($model,'idpurchaseorder'); ?>
		<?php    
         echo $form->dropDownList($model,'idpurchaseorder',
            array($model->idpurchaseorder=>lookup::PurchasesOrderNumFromID($model->idpurchaseorder)), 
            array('empty'=>'Harap Pilih')
         );
      ?>
		<?php echo $form->error($model,'idpurchaseorder'); ?>
      </div>
   
   <div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
         <?php 
            echo $form->textArea($model, 'remark', array('rows'=>6, 'cols'=>50));
         ?>
         <?php echo $form->error($model,'remark'); ?>
	</div>
      
<?php 
    if (isset(Yii::app()->session['Detailpurchasesmemos'])) {
       $rawdata=Yii::app()->session['Detailpurchasesmemos'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailpurchasesmemos where id='$model->idpurchaseorder'")
            ->queryScalar();
       $sql="select * from detailpurchasesmemos where id='$model->idpurchaseorder'";
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
                  'header'=>'Qty',
                  'type'=>'number',
                  'name'=>'qty',
               ),
               array(
                  'header'=>'Harga Akhir',
                  'type'=>'number',
                  'name'=>'prevprice',
               ), 
               array(
                  'header'=>'Harga Baru',
                  'type'=>'number',
                  'name'=>'price',
               ), 
               array(
                  'header'=>'Biaya 1 Akhir',
                  'type'=>'number',
                  'name'=>'prevcost1',
               ), 
               array(
                  'header'=>'Biaya 1 Baru',
                  'type'=>'number',
                  'name'=>'cost1',
               ), 
               /*array(
                  'header'=>'Biaya 1 Akhir',
                  'type'=>'number',
                  'name'=>'prevcost2',
               ), 
               array(
                  'header'=>'Biaya 1 Awal',
                  'type'=>'number',
                  'name'=>'cost2',
               ),*/ 
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
                  'updateButtonUrl'=>"Action::decodeUpdateDetailPurchaseMemoUrl(\$data)",
               )
          ),
    ));
    
?>

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->