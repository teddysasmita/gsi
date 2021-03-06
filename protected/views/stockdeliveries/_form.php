<?php
/* @var $this StockdeliveriesController */
/* @var $model Stockdeliveries */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockdeliveries-form',
	'enableAjaxValidation'=>false,
      'action'=>Yii::app()->createUrl("stockdeliveries/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockdeliveries-form',
	'enableAjaxValidation'=>false,
      'action'=>Yii::app()->createUrl("stockdeliveries/update", array('id'=>$model->id))
      ));
   ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

      <?php
         echo $form->hiddenfield($model,'id');   
         echo $form->hiddenField($model,'userlog');
         echo $form->hiddenField($model,'datetimelog');
         
         echo CHtml::hiddenField('command');
      ?>
      
	<div class="row">
		<?php echo $form->labelEx($model,'regnum'); ?>
		<?php echo $form->textField($model,'regnum',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'regnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idatetime'); ?>
		<?php 
            //echo $form->dateField($model,'idatetime',array('size'=>19,'maxlength'=>19)); 
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
               'name'=>'Stockdeliveries[idatetime]',
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
            ?> <?php echo $form->error($model,'idatetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idcustomer'); ?>
		<?php 
            $res=Yii::app()->db->createCommand("select id, concat(firstname,' ',lastname) as name from customers")
               ->queryAll();
            $datas=CHtml::listData($res,'id', 'name');
            echo $form->dropDownList($model,'idcustomer',$datas); 
            ?>
		<?php echo $form->error($model,'idcustomer'); ?>
	</div>

      <?php
   if (isset(Yii::app()->session['Detailstockdeliveries'])) {
      $rawdata=Yii::app()->session['Detailstockdeliveries'];
      $count=count($rawdata);
   } else {
      $count=Yii::app()->db->createCommand("select count(*) from detailstockdeliveries where id='$model->id'")->queryScalar();
      $sql="select * from detailstockdeliveries where id='$model->id'";
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
              'name'=>'qty',
          ),
         
          array(
              'class'=>'CButtonColumn',
              'buttons'=> array(
                  'delete'=>array(
                      'visible'=>'false'
                  )
              ),
              'deleteButtonUrl'=>"lookup::decodeDeleteDetailStockDeliveryUrl(\$data)",
              'viewButtonUrl'=>"lookup::decodeViewDetailStockDeliveryUrl(\$data)",
              'updateButtonUrl'=>"lookup::decodeUpdateDetailStockDeliveryUrl(\$data)"
          )
      ),
));
 ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton(ucfirst($command)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->