<?php
/* @var $this DetailsalesordersController */
/* @var $model Detailsalesorders */

$this->breadcrumbs=array(
   'Lihat Data'=>array('/default/view', 'id'=>$model->id),
   'Ubah Data'=>array('/default/update', 'id'=>$model->id),
   'Lihat Detil'=>array('view','iddetail'=>$model->iddetail),
   'Sejarah',
);

$this->menu=array(
	array('label'=>'List Detailsalesorders', 'url'=>array('index')),
	array('label'=>'Create Detailsalesorders', 'url'=>array('create')),
);

?>

<h1>Detil Pemesanan oleh Pelanggan</h1>

<?php 
    $data=Yii::app()->tracker->createCommand()->
       select()->from('detailsalesorders')->where("iddetail='$model->iddetail'")->queryAll();
    $ap=new CArrayDataProvider($data);
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detailsalesorders-grid',
	'dataProvider'=>$ap,
	'columns'=>array(
		array(
                   'name'=>'Nama Barang',
                   'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])",
                ),
		'qty',
		'discount',
		'price',
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
                   'updateButtonUrl'=>"Action::decodeRestoreHistoryDetailsalesorderUrl(\$data)",
		),
	),
    )); 
?>
