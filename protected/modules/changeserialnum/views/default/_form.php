   <?php	
/* @var $this ChangeserialnumController */
/* @var $model Changeserialnum */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
   $transScript=<<<EOS
		$('#Changeserialnum_itemname').focus(function(){
			$('#ItemDialog').dialog('open');
      	});
      
		$('#dialog-item-name').change(
			function(){
            	$.getJSON('index.php?r=LookUp/getItem',{ name: $('#dialog-item-name').val() },
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
   
		$('#findItem').click( function() {
			$.getJSON('index.php?r=LookUp/checkItemSerial2',{ iditem: $('#Changeserialnum_iditem').val(),
				serialnum: $('#Changeserialnum_oldserialnum').val() },
               	function(data) {
                  	if (data !== '0') {
						$('#status').val('good');
						$('#serialstatus').html('Item dgn nomor seri tersebut terdaftar');
						$('#serialstatus').addClass('money');
					} else {
						$('#status').val('bad');
						$('#serialstatus').html('Item dgn nomor seri tersebut TIDAK terdaftar');
						$('#serialstatus').addClass('errorMessage');
					};
               	})
		
		});
   
EOS;
   Yii::app()->clientScript->registerScript("transScript", $transScript, CClientscript::POS_READY);

   if($command=='create') 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changeserialnum-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/changeserialnum/default/create")
      ));
   else if($command=='update')
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changeserialnum-form',
	'enableAjaxValidation'=>true,
      'action'=>Yii::app()->createUrl("/changeserialnum/default/update", array('id'=>$model->id))
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
        echo $form->hiddenField($model, 'iditem');
        echo CHtml::hiddenField('status', '', array('id'=>'status'));
      ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'idatetime'); ?>
            <?php
               $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                  'name'=>'Changeserialnum[idatetime]',
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
		<?php echo $form->labelEx($model,'iditem'); ?>
		<?php 
               echo CHtml::textField('Changeserialnum_itemname', lookup::ItemNameFromItemID($model->iditem) , array('size'=>50));   
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
                             $(\'#Changeserialnum_itemname\').val($(\'#dialog-item-name\').val());
                             $.get(\'index.php?r=LookUp/getItemID\',{ name: encodeURI($(\'#dialog-item-name\').val()) },
                                 function(data) {
                                    $(\'#Changeserialnum_iditem\').val(data);
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
		<?php echo $form->labelEx($model,'oldserialnum'); ?>
		<?php echo $form->textField($model,'oldserialnum'); 
			echo CHtml::button('Cari', array('id'=>'findItem'));
		?>
		<?php echo $form->error($model,'oldserialnum'); ?>
	</div>
	
	
	
	<div class="row">
		<?php echo CHtml::label('Nomor Seri Lama', false); ?>
		<?php echo CHtml::tag("span", array('id'=>'serialstatus')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'newserialnum'); ?>
		<?php echo $form->textField($model,'newserialnum'); ?>
		<?php echo $form->error($model,'newserialnum'); ?>
	</div>
	

   <div class="row buttons">
      <?php echo CHtml::submitButton(ucfirst($command)); ?>
   </div>

<?php $this->endWidget(); ?>


      
</div><!-- form -->