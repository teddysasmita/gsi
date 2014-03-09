<?php
/* @var $this Detaildeliveryorderss2Controller */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Daftar'=>,
);

$this->menu=array(
	array('label'=>'Create Detaildeliveryorderss2', 'url'=>array('create')),
	array('label'=>'Manage Detaildeliveryorderss2', 'url'=>array('admin')),
);
?>

<h1>Detil Pengiriman Barang 2</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
