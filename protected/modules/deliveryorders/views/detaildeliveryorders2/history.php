<?php
/* @var $this Detaildeliveryorders2Controller */
/* @var $model Detaildeliveryorders2 */

$this->breadcrumbs=array(
	'Proses'=>array('/site/proses'),
   'Daftar'=>array('default/index'),
   'Lihat Data'=>array('default/view', 'id'=>$model->id),
   'Ubah Data'=>array('default/update', 'id'=>$model->id),
   'Lihat Detil'=>array('/deliveryorders/detaildeliveryorders2/view',
         'iddetail'=>$model->iddetail),
   'Sejarah'
);

$this->menu=array(
	//array('label'=>'List Detaildeliveryorders2', 'url'=>array('index')),
	//array('label'=>'Create Detaildeliveryorders2', 'url'=>array('create')),
);

?>

<h1>Detil Pengiriman Barang 2</h1>

<?php    $data=Yii::app()->tracker->createCommand()->
       select()->from('detaildeliveryorders2')->where('id=:id',array(':id'=>$model->iddetail))->queryAll();
    $ap=new CArrayDataProvider($data);
 ?> 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detaildeliveryorders2-grid',
	'dataProvider'=>$ap,
	'columns'=>array(
		//'iddetail',
		//'id',
		'vouchername',
		'vouchervalue',
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
