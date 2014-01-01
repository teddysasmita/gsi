<?php
/* @var $this ItemsController */
/* @var $model Items */

$this->breadcrumbs=array(
   'Proses'=>array('/site/proses'),
	'Daftar'=>array('index'),
	'Cetak Kartu Stok',
);

$this->menu=array(
	array('label'=>'Pencarian Data', 'url'=>array('admin')),
);
?>

<h1>Item Penjualan</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'printstockcard-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>


	<div class="row">
		<?php echo CHtml::label('Pilih Gudang', false); ?>
		<?php
			$data=CHtml::listData($warehouses, 'id', 'code'); 
			echo CHtml::dropDownList('idwarehouse', false, $data, 
				array('empty'=>'Harap Pilih')); 
		?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->

