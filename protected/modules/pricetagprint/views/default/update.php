<?php
/* @var $this PricetagprintsController */
/* @var $model Pricetagprints */

$this->breadcrumbs=array(
      'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Lihat Data'=>array('view','id'=>$model->id),
	'Ubah Data',
);

$this->menu=array(
	//array('label'=>'List Pricetagprints', 'url'=>array('index')),
	//array('label'=>'Create Pricetagprints', 'url'=>array('create')),
	//array('label'=>'View Pricetagprints', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Pricetagprints', 'url'=>array('admin')),
    array('label'=>'Tambah Detil', 'url'=>array('detailpricetagprints/create', 
       'id'=>$model->id, 'command'=>'update', 'regnum'=>$model->regnum),
          'linkOptions'=>array('id'=>'adddetail')), 
);
?>

<h1>Buat Label Harga</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'command'=>'update')); ?>