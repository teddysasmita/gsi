<?php
/* @var $this SalesposbanksController */
/* @var $model Salesposbanks */

$this->breadcrumbs=array(
	'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Tambah Data',
);

$this->menu=array(
	array('label'=>'Pencarian Data', 'url'=>array('admin')),
);
?>

<h1>Bank Penerbit Kartu</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>