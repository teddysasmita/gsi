<?php
/* @var $this OrderretrievalsController */
/* @var $model Orderretrievals */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Sejarah',
);

$this->menu=array(
	array('label'=>'Daftar', 'url'=>array('index')),
	array('label'=>'Tambah Data', 'url'=>array('create')),
);

?>

<h1>Pengambilan Barang</h1>

<?php    $data=Yii::app()->tracker->createCommand()->
       select()->from('orderretrievals')->where('id=:id',array(':id'=>$model->id))->queryAll();
    $ap=new CArrayDataProvider($data);
 ?> 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orderretrievals-grid',
	'dataProvider'=>$ap,
	'columns'=>array(
		'id',
		'regnum',
		'idatetime',
		'rdatetime',
		'idsupplier',
		'total',
		/*
		'discount',
		'status',
		'remark',
		'userlog',
		'datetimelog',
		*/
		array(
                    'class'=>'CButtonColumn',
                   'buttons'=> array(
                        'view'=>array(
                            'visible'=>'false',
                        ),
                        'delete'=>array(
                          'visible'=>'false',
                        ),
                    ),
                   'updateButtonUrl'=>"Action::decodeRestoreHistoryCustomerUrl(\$data)",
		),
	),
)); ?>
