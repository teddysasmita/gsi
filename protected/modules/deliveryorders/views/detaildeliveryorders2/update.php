<?php
/* @var $this Detaildeliveryorders2Controller */
/* @var $model Detaildeliveryorders2 */

$master=Yii::app()->session['master'];
if($master=='create')
   $this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
	'Daftar'=>array('default/index'),
	'Tambah Data'=>array('default/create','id'=>$model->id),
   'Ubah Detil'); 
else if ($master=='update')
   $this->breadcrumbs=array(
	'Proses'=>array('/site/proses'),
   'Daftar'=>array('default/index'),
   'Lihat Data'=>array('default/view','id'=>$model->id),
	'Ubah Data'=>array('default/update','id'=>$model->id),
   'Ubah Detil');

$this->menu=array(
	//array('label'=>'List Detaildeliveryorders2', 'url'=>array('index')),
	//array('label'=>'Create Detaildeliveryorders2', 'url'=>array('create')),
	//array('label'=>'View Detaildeliveryorders2', 'url'=>array('view', 'id'=>$model->iddetail)),
	//array('label'=>'Manage Detaildeliveryorders2', 'url'=>array('admin')), 
);
?>

<h1>Detil Pengiriman Barang 2</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'mode'=>'Update')); ?>