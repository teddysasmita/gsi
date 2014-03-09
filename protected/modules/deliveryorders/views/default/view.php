<?php
/* @var $this DeliveryordersController */
/* @var $model Deliveryorders */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
   'Daftar'=>array('index'),
   'Lihat Data',
);

$this->menu=array(
	array('label'=>'Tambah Data', 'url'=>array('create')),
	array('label'=>'Ubah Data', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Hapus Data', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Pencarian Data', 'url'=>array('admin')),
      array('label'=>'Sejarah', 'url'=>array('history', 'id'=>$model->id)),
      array('label'=>'Data Detil yang dihapus', 
         'url'=>array('/purchasesorder/detaildeliveryorders/deleted', 'id'=>$model->id)),
      array('label'=>'Data Detil Voucher yang dihapus', 
         'url'=>array('/purchasesorder/detaildeliveryorders2/deleted', 'id'=>$model->id)),
);
?>

<h1>Pengiriman Barang</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'regnum',
		'idatetime',
		array(
			'label'=>'Nomor Faktur',
			'name'=>'invnum',
		),
		array(
			'label'=>'Supir',
			'name'=>'drivername'
		),
		array(
			'label'=>'Info Kendaraan',
			'name'=>'vehicleinfo'
		),
		array(
			'label'=>'Penerima',
			'name'=>'receivername'
		),
		array(
			'label'=>'Alamat',
			'name'=>'receiveraddress'
		),
		array(
			'label'=>'Nomor Telp',
			'name'=>'receiverphone'
		),
		array(
               'label'=>'Userlog',
               'value'=>lookup::UserNameFromUserID($model->userlog),
            ),
		'datetimelog',
      
	),
)); ?>

<?php 
   $count=Yii::app()->db->createCommand("select count(*) from detaildeliveryorders where id='$model->id'")
      ->queryScalar();
   $sql="select * from detaildeliveryorders where id='$model->id'";

   $dataProvider=new CSqlDataProvider($sql,array(
		'totalItemCount'=>$count,
	));
   $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'columns'=>array(
			array(
				'header'=>'Item Name',
				'name'=>'iditem',
				'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])"
			),
			array(
				'header'=>'Faktur',
				'name'=>'invqty',
			),
			array(
				'header'=>'Sisa',
				'name'=>'leftqty',
			),
			array(
				'header'=>'Jumlah',
				'name'=>'qty',
			),
            array(
               'class'=>'CButtonColumn',
               'buttons'=> array(
                   'delete'=>array(
                    'visible'=>'false'
                   ),
                  'update'=>array(
                     'visible'=>'false'
                  )
               ),
               'viewButtonUrl'=>"Action::decodeViewDetailPurchasesOrderUrl(\$data, $model->regnum)",
            )
         ),
   ));
   
   $count=Yii::app()->db->createCommand("select count(*) from detaildeliveryorders2 where id='$model->id'")
      ->queryScalar();
   $sql="select * from detaildeliveryorders2 where id='$model->id'";

   $dataProvider=new CSqlDataProvider($sql,array(
          'totalItemCount'=>$count,
          ));
   $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'columns'=>array(
				array(
						'header'=>'Item Name',
						'name'=>'iditem',
						'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])"
				),
				array(
						'header'=>'Jumlah',
						'name'=>'qty',
				),
				array(
						'header'=>'Gudang',
						'name'=>'idwarehouse',
						'value'=>"lookup::WarehouseNameFromWarehouseID(\$data['idwarehouse'])"
				),
				array(
						'class'=>'CButtonColumn',
						'buttons'=> array(
								'delete'=>array(
										'visible'=>'false'
								),
								'update'=>array(
										'visible'=>'false'
								)
						),
						'viewButtonUrl'=>"Action::decodeViewDetailPurchasesOrderUrl(\$data, $model->regnum)",
				)
		),
	));
 ?>
