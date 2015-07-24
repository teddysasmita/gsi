<?php
/* @var $this DetailpricetagprintsController */
/* @var $model Detailpricetagprints */


 $this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
   'Daftar'=>array('default/index'),
   'Lihat Data'=>array('default/view', 'id'=>$model->id),
   'Lihat Detil'
 );

$this->menu=array(
	/*array('label'=>'List Detailpricetagprints', 'url'=>array('index')),
	array('label'=>'Create Detailpricetagprints', 'url'=>array('create')),
	array('label'=>'Update Detailpricetagprints', 'url'=>array('update', 'id'=>$model->iddetail)),
	array('label'=>'Delete Detailpricetagprints', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->iddetail),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Detailpricetagprints', 'url'=>array('admin')),
   array('label'=>'Ubah Detil', 'url'=>array('detailpricetagprints/update',
      'iddetail'=>$model->iddetail)),
   */
   array('label'=>'Sejarah', 'url'=>array('history', 'iddetail'=>$model->iddetail)),
);
?>

<h1>Detil Buat Label Hargak</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'iddetail',
		//'id',
		array(
         'label'=>'Nama Barang',
         'value'=>lookup::ItemNameFromItemID($model->iditem)
      ),
		//'idunit',
		array(
         'label'=>'Jumlah',
         'value'=>$model->qty
      ),
		array(
         'label'=>'Userlog',
         'value'=>lookup::UserNameFromUserID($model->userlog),
      ),
		'datetimelog',
	),
)); ?>
