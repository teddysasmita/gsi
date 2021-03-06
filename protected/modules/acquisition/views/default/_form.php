   <?php
/* @var $this AcquisitionsController */
/* @var $model Acquisitions */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
   $transScript=<<<EOS
		$('.updateButton').click(
		function(evt) {
			$('#command').val('updateDetail');
			$('#detailcommand').val(this.href);
			$('#acquisitions-form').submit();
		});  

		$('#Acquisitions_itemname').click(function(){
			$('#ItemDialog').dialog('open');
      	});
      
		$('#dialog-item-name').change(
			function(){
            	$.getJSON('index.php?r=LookUp/getItem4',{ name: $('#dialog-item-name').val() },
               	function(data) {
                  	$('#dialog-item-select').html('');
                  	var ct=0;
                  	while(ct < data.length) {
                     	$('#dialog-item-select').append(
                        	'<option value='+data[ct]+'>'+unescape(data[ct])+'</option>'
                     	);
                     	ct++;
                  	}
               	})
         	}
      	);
		$('#dialog-item-select').click(
			function(){
				$('#dialog-item-name').val(unescape($('#dialog-item-select').val()));
			}
		);
   
		$('#Acquisitions_qty').change(
   		function(event) {
			$('#command').val('setQty');
			$('#acquisitions-form').submit();
		});
EOS;
   Yii::app()->clientScript->registerScript("transScript", $transScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'acquisitions-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/acquisition/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'acquisitions-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/acquisition/default/update", array('id'=>$model->id))
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
        echo $form->hiddenField($model, 'iditem');
      ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'idatetime'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Acquisitions[idatetime]',
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
		<?php echo $form->labelEx($model,'idwarehouse'); ?>
		<?php
			$warehouses = lookup::WarehouseNameFromIpAddr($_SERVER['REMOTE_ADDR']);
         	if (count($warehouses) > 1) {
				$data = CHtml::listData($warehouses, 'id', 'code');
         		echo CHtml::dropDownList('Acquisitions[idwarehouse]', '', $data, 
					array('empty'=>'Harap Pilih'));
         	} else if (count($warehouses) > 0) {
				echo CHtml::hiddenField('Acquisitions[idwarehouse]', $warehouses[0]['id']);
				echo CHtml::label($warehouses[0]['code'],'false', array('class'=>'money')); 
			} else {
				echo CHtml::hiddenField('Acquisitions[idwarehouse]', '');
				echo CHtml::label($_SERVER['REMOTE_ADDR'].' tdk terdaftar sebagai gudang.','false', array('class'=>'error'));
			}
				
		?>
		<?php echo $form->error($model,'idwarehouse'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'iditem'); ?>
		<?php 
               echo CHtml::textField('Acquisitions_itemname', lookup::ItemNameFromItemID($model->iditem) , array('size'=>50));   
               $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                  'id'=>'ItemDialog',
                  'options'=>array(
                      'title'=>'Pilih Barang',
                      'autoOpen'=>false,
                      'height'=>300,
                      'width'=>600,
                      'modal'=>true,
                      'buttons'=>array(
                          array('text'=>'Ok', 'click'=>'js:function(){
                             $(\'#Acquisitions_itemname\').val($(\'#dialog-item-name\').val());
                             $.get(\'index.php?r=LookUp/getItemID2\',{ namecode: encodeURI($(\'#dialog-item-name\').val()) },
                                 function(data) {
                                    $(\'#Acquisitions_iditem\').val(data);
                                 })
                             $(this).dialog("close");
                           }'),
                          array('text'=>'Close', 'click'=>'js:function(){
                              $(this).dialog("close");
                          }'),
                      ),
                  ),
               ));
               $myd=<<<EOS
         
            <div><input type="text" name="itemname" id="dialog-item-name" size='50'/></div>
            <div><select size='8' width='100' id='dialog-item-select'>   
                <option>Harap Pilih</option>
            </select>           
            </div>
            </select>           
EOS;
               echo $myd;
               $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
		<?php echo $form->error($model,'iditem'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>
	
	
<?php 
    if (isset(Yii::app()->session['Detailacquisitions'])) {
       $rawdata=Yii::app()->session['Detailacquisitions'];
       $count=count($rawdata);
    } else {
       $count=Yii::app()->db->createCommand("select count(*) from detailacquisitions where id='$model->id'")->queryScalar();
       $sql="select * from detailacquisitions where id='$model->id'";
       $rawdata=Yii::app()->db->createCommand($sql)->queryAll ();
    }
    $dataProvider=new CArrayDataProvider($rawdata, array(
          'totalItemCount'=>$count,
		  'keyField'=>'iddetail',
    ));
    $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
              array(
                  'header'=>'Nomor Seri',
                  'name'=>'serialnum',
              ),
				array(
					'header'=>'Status',
					'name'=>'avail',
					'value'=>"lookup::StockAvailName(\$data['avail'])",
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
				'updateButtonOptions'=>array("class"=>'updateButton'),
                  'updateButtonUrl'=>"Action::decodeUpdateDetailAcquisitionsUrl(\$data)",
              )
          ),
    ));
?>

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->