<?php
/* @var $this DeliveryordersController */
/* @var $model Deliveryorders */

$this->breadcrumbs=array(
      'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Tambah Data',
);

$this->menu=array(
	//array('label'=>'Daftar', 'url'=>array('index')),
	//array('label'=>'Pengaturan', 'url'=>array('admin')),
      array('label'=>'Tambah Detil', 'url'=>array('detaildeliveryorders/create', 
         'id'=>$model->id),
          'linkOptions'=>array('id'=>'adddetail')), 
      array('label'=>'Tambah Detil2', 'url'=>array('detaildeliveryorders2/create', 
         'id'=>$model->id),
          'linkOptions'=>array('id'=>'adddetail2')) 
);

$jq=<<<EOH
   $('#adddetail').click(function(event){
     var mainform;
     var hiddenvar;
     mainform=$('#deliveryorders-form');
     $('#command').val('adddetail');
     mainform.submit();
     event.preventDefault();
   });
   $('#adddetail2').click(function(event){
     var mainform;
     var hiddenvar;
     mainform=$('#deliveryorders-form');
     $('#command').val('adddetail2');
     mainform.submit();
     event.preventDefault();
   });
EOH;
Yii::app()->clientScript->registerScript('myscript', $jq, CClientScript::POS_READY);
?>

<h1>Pengiriman Barang</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'id'=>$model->id, 'command'=>'create')); ?>