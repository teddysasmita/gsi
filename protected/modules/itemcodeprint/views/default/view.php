<?php
/* @var $this ItemcodeprintsController */
/* @var $model Itemcodeprints */

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
         'url'=>array('/itemcodeprint/detailitemcodeprints/deleted', 'id'=>$model->id)),
	array('label'=>'Cetak', 'url'=>array('printitemcode', 'id'=>$model->id)),
);
?>

<h1>Cetak Kode Master Barang</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'regnum',
		'idatetime',
		'itemcodetype',
		'labelheight',
		'labelwidth',
		'papersize',
		array(
			'label'=>'Userlog',
			'value'=>lookup::UserNameFromUserID($model->userlog),
		),
		'datetimelog',
	),
)); ?>

<?php 
   $count=Yii::app()->db->createCommand("select count(*) from detailitemcodeprints where id='$model->id'")
      ->queryScalar();
   $sql="select * from detailitemcodeprints where id='$model->id'";

   $dataProvider=new CSqlDataProvider($sql,array(
          'totalItemCount'=>$count,
          ));
   $this->widget('zii.widgets.grid.CGridView', array(
         'dataProvider'=>$dataProvider,
         'columns'=>array(
            array(
               'header'=>'Nama Barang',
               'name'=>'iditem',
            	'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])",
            ),
         	array(
				'header'=>'Nomor',
         		'name'=>'num',
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
                  'viewButtonUrl'=>"Action::decodeViewDetailItemcodePrintUrl(\$data)",
              )
         ),
   ));
 ?>
