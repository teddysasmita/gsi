<?php
/* @var $this DetailsalesordersController */
/* @var $model Detailsalesorders */

$master=Yii::app()->session['master'];
if($master=='create') {
   $this->breadcrumbs=array(
      'Proses'=>array('/site/proses'),
      'Daftar'=>array('default/index'),
      'Tambah Data'=>array('default/create','id'=>$model->id),
      'Ubah Detil'); 
} else if ($master=='update') {
   $this->breadcrumbs=array(
      'Proses'=>array('/site/proses'),
      'Daftar'=>array('default/index'),
      'Lihat Data'=>array('default/view', 'id'=>$model->id),
      'Ubah Data'=>array('default/update', 'id'=>$model->id),
      'Ubah Detil',
   );
}   

$this->menu=array(
	/*
   array('label'=>'List Detailsalesorders', 'url'=>array('index')),
	array('label'=>'Create Detailsalesorders', 'url'=>array('create')),
	array('label'=>'View Detailsalesorders', 'url'=>array('view', 'iddetail'=>$model->iddetail)),
	array('label'=>'Manage Detailsalesorders', 'url'=>array('admin')),
   */
 );
?>

<h1>Detil Pemesanan oleh Pelanggan</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'mode'=>'Update')); ?>