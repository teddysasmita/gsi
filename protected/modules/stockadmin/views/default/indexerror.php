<?php
/* @var $this StockAdminController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
	'Daftar',
);

$this->menu=array(
   
);
?>

<h1>Error Stok</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewerror',
)); ?>
