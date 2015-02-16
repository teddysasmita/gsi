<?php
/* @var $this ChangeserialnumController */
/* @var $model Changeserialnum */

$this->breadcrumbs=array(
      'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Lihat Data'=>array('view','id'=>$model->id),
	'Ubah Data',
);

$this->menu=array(
	//array('label'=>'List Changeserialnum', 'url'=>array('index')),
	//array('label'=>'Create Changeserialnum', 'url'=>array('create')),
	//array('label'=>'View Changeserialnum', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Changeserialnum', 'url'=>array('admin')),
    array('label'=>'Tambah Detil', 'url'=>array('detailchangeserialnum/create', 
       'id'=>$model->id, 'command'=>'update', 'regnum'=>$model->regnum),
          'linkOptions'=>array('id'=>'adddetail')), 
);
?>

<h1>Perubahan Nomor Seri</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'command'=>'update')); ?>