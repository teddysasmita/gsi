<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
		'Proses'=>array('/site/proses'),
		'Daftar',
);
?>

<h1><?php echo "Administrasi Persediaan (Stok)" ?></h1>

<h3><?php echo CHtml::link('Berdasarkan Kuantitas dan Lokasi', 
		Yii::app()->createUrl('stockadmin/default/quantity'))?></h3> 
<h3><?php echo CHtml::link('Berdasarkan Nomor Seri dan Lokasi', 
		Yii::app()->createUrl('stockadmin/default/serial'))?></h3>
