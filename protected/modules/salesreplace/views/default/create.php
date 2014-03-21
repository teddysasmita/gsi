<?php
/* @var $this SalesreplaceController */
/* @var $model Salesreplace */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Tambah Data',
);

$this->menu=array(
	//array('label'=>'Daftar Perubahan Penjualan', 'url'=>array('index')),
	array('label'=>'Cari Perubahan Penjualan', 'url'=>array('admin')),
);
?>

<h1>Perubahan Penjualan</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>