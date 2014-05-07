<?php
/* @var $this StockentriesController */
/* @var $model Stockentries */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
   'Daftar'=>array('index'),
   'Lihat Data',
);

$this->menu=array(
	
);
?>

<h1>Error Stok Keluar</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'regnum',
		'idatetime',
		array(
			'label'=>'Userlog',
			'value'=>lookup::UserNameFromUserID($model->userlog),
		),
		'datetimelog',
	),
)); ?>

<?php 
   $count=Yii::app()->db->createCommand("select count(*) from detailerrors where id='$model->id'")
      ->queryScalar();
   $sql="select * from detailerrors where id='$model->id'";

   $dataProvider=new CSqlDataProvider($sql,array(
          'totalItemCount'=>$count,
          ));
   $this->widget('zii.widgets.grid.CGridView', array(
         'dataProvider'=>$dataProvider,
         'columns'=>array(
            array(
               'header'=>'Barang',
               'name'=>'iditem',
               'value'=>"lookup::ItemNameFromItemID(\$data['iditem'])"
            ),
            array(
              'header'=>'Serial Number',
              'name'=>'serialnum ',
              'value'=>"\$data['serialnum']"
            ),
         	array(
				'header'=>'Catatan',
				'name'=>'remark',
				'type'=>"ntext"
         	),
         	/*
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
                  'viewButtonUrl'=>"Action::decodeViewDetailStockEntryUrl(\$data)",
              )
             */
         ),
   ));
 ?>
