<?php
/* @var $this ItemcodeprintsController */
/* @var $model Itemcodeprints */

$this->breadcrumbs=array(
      'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Lihat Data'=>array('view','id'=>$model->id),
	'Ubah Data',
);

$this->menu=array(
	//array('label'=>'List Itemcodeprints', 'url'=>array('index')),
	//array('label'=>'Create Itemcodeprints', 'url'=>array('create')),
	//array('label'=>'View Itemcodeprints', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Itemcodeprints', 'url'=>array('admin')),
    array('label'=>'Tambah Detil', 'url'=>array('detailitemcodeprints/create', 
       'id'=>$model->id, 'command'=>'update', 'regnum'=>$model->regnum),
          'linkOptions'=>array('id'=>'adddetail')), 
);
?>

<h1>Cetak Barcode Kode Master Barang</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'command'=>'update')); ?>