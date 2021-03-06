<?php
/* @var $this SalesposcardsController */
/* @var $model Salesposcards */

$this->breadcrumbs=array(
	'Master Data'=>array('/site/masterdata'),
	'Daftar'=>array('index'),
	'Sejarah',
);

$this->menu=array(
	array('label'=>'Tambah Data', 'url'=>array('create')),
);

?>

<h1>Jenis Kartu</h1>

<?php    $data=Yii::app()->tracker->createCommand()->
       select()->from('salesposcards')->where('id=:id',array(':id'=>$model->id))->queryAll();
    $ap=new CArrayDataProvider($data);
 ?> 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'salesposcards-grid',
	'dataProvider'=>$ap,
	'columns'=>array(
		'id',
		'name',
		'idbank',
		'type',
		'userlog',
		'datetimelog',
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
