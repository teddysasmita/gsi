<?php
/* @var $this Detaildeliveryorders2Controller */
/* @var $model Detaildeliveryorders2 */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
   'Daftar'=>array('default/index'),
   'Lihat Data'=>array('default/view','id'=>$model->id),
   'Lihat Detil'
 );

$this->menu=array(
	/*array('label'=>'List Detaildeliveryorders2', 'url'=>array('index')),
	array('label'=>'Create Detaildeliveryorders2', 'url'=>array('create')),
	array('label'=>'Update Detaildeliveryorders2', 'url'=>array('update', 'id'=>$model->iddetail)),
	array('label'=>'Delete Detaildeliveryorders2', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->iddetail),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Detaildeliveryorders2', 'url'=>array('admin')),
   array('label'=>'Ubah Detil', 'url'=>array('/purchasesorder/detaildeliveryorders2/update',
      'iddetail'=>$model->iddetail)),
   */
   array('label'=>'Sejarah', 'url'=>array('history', 'iddetail'=>$model->iddetail)),
);
?>

<h1>Detil Pengiriman Barang 2</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'iddetail',
		//'id',
		array(
			'name'=>'iditem',
			'value'=>lookup::ItemNameFromItemID($model->iditem)
		),
		'qty',
		array(
			'name'=>'idwarehouse',
			'value'=>lookup::WarehouseNameFromWarehouseID($model->idwarehouse)
		),
		array(
               'label'=>'userlog',
               'value'=>lookup::UserNameFromUserID($model->userlog)
            ), 
		'datetimelog',
	),
)); ?>
