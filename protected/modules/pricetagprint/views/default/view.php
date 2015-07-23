<?php
/* @var $this PricetagprintsController */
/* @var $model Pricetagprints */

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
         'url'=>array('/pricetagprint/detailpricetagprints/deleted', 'id'=>$model->id)),
	array('label'=>'Cetak', 'url'=>array('printpricetag', 'id'=>$model->id)),
);
?>

<h1>Buat Label Harga</h1>

<?php 
	$tmppath = Yii::app()->assetManager->basePath.'/pricetagprint'.$model->id;
	$tmpfile = fopen($tmppath, 'w');
	fwrite($tmpfile, $model->bkjpg);
	fclose($tmpfile);
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'regnum',
		'idatetime',
		'papersize',
		'paperwidth',
		'paperheight',
		'labelwidth',
		'labelheight',
		'itemnamex',
		'itemnamey',
		'itemnamew',
		'itemnameh',
		'itemnameft',
		'itemnamefz',
		'itemnamec',
		'pricex',
		'pricey',
		'pricew',
		'priceh',
		'priceft',
		'pricefz',
		'pricec',
		'extrax',
		'extray',
		'extraw',
		'extrah',
		'extraft',
		'extrafz',
		'extrac',
		array(
			'name'=>'bkjpg',
			'value'=>Yii::app()->assetManager->baseUrl.'/pricetagprint'.$model->id,
			'type'=>'image'		
		),
		array(
			'label'=>'Userlog',
			'value'=>lookup::UserNameFromUserID($model->userlog),
		),
		'datetimelog',
	),
)); 
	?>

<?php 
   $count=Yii::app()->db->createCommand("select count(*) from detailpricetagprints where id='$model->id'")
      ->queryScalar();
   $sql="select * from detailpricetagprints where id='$model->id'";

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
         		'name'=>'qty',
         		'type'=>'number',		
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
                  'viewButtonUrl'=>"Action::decodeViewDetailPricetagPrintUrl(\$data)",
              )
         ),
   ));
 ?>
