<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Master Data</h1>

<h3><?php echo CHtml::link('Barang Dagang', Yii::app()->createUrl('item'))?></h3>
<h3><?php echo CHtml::link('Pelanggan', Yii::app()->createUrl('customer'))?></h3>
<h3><?php echo CHtml::link('Pemasok', Yii::app()->createUrl('supplier'))?></h3>
<h3><?php echo CHtml::link('Gudang', Yii::app()->createUrl('warehouse'))?></h3>
<h3><?php echo CHtml::link('Tenaga Penjualan (Sales)', Yii::app()->createUrl('salesperson'))?></h3>