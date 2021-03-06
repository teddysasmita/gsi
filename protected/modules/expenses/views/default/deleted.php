<?php
/* @var $this ExpensesController */
/* @var $model Expenses */

$this->breadcrumbs=array(
   'Master Data'=>array('/site/master Data'),
   'Daftar'=>array('index'),
   'Data yang telah Terhapus',
);

$this->menu=array(
	array('label'=>'Tambah Data', 'url'=>array('create')),
);

?>

<h1>Biaya</h1>

<?php 
    $data=Yii::app()->tracker->createCommand()
       ->select('a.*')->from('expenses a')->join('userjournal b', 'b.id=a.idtrack')
       ->where('b.action=:action', array(':action'=>'d'))->queryAll();
    $ap=new CArrayDataProvider($data);
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'expenses-grid',
	'dataProvider'=>$ap,
	'columns'=>array(
		//'id',
		'name',
		'accountnum',
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
                   'updateButtonUrl'=>"Action::decodeRestoreDeletedExpenseUrl(\$data)",
		),
	),
    )); 
?>
