<?php
/* @var $this DetailinputinventorytakingsController */
/* @var $model Detailinputinventorytakings */

$this->breadcrumbs=array(
   'Lihat Data'=>array('/default/view', 'id'=>$model->id),
   'Ubah Data'=>array('/default/update', 'id'=>$model->id),
   'Lihat Detil'=>array('view','iddetail'=>$model->iddetail),
   'Sejarah',
);

$this->menu=array(
	array('label'=>'List Detailinputinventorytakings', 'url'=>array('index')),
	array('label'=>'Create Detailinputinventorytakings', 'url'=>array('create')),
);

?>

<h1>Input Stok Opname</h1>

<?php 
    $data=Yii::app()->tracker->createCommand()->
       select()->from('detailinputinventorytakings')->where("iddetail='$model->iddetail'")->queryAll();
    $ap=new CArrayDataProvider($data);
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detailinputinventorytakings-grid',
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
                   'updateButtonUrl'=>"Action::decodeRestoreHistoryDetailinputinventorytakingUrl(\$data)",
		),
	),
    )); 
?>
