<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Proses</h1>

<h2>Bagian Pembelian</h2>
<h3><?php echo CHtml::link('Pesanan ke Pemasok', Yii::app()->createUrl('purchasesorder'))?></h3>
<h3><?php echo CHtml::link('Penerimaan Barang dari Pemasok', Yii::app()->createUrl('purchasesreceipt'))?></h3>
<h3><?php echo CHtml::link('Pembayaran ke Pemasok', Yii::app()->createUrl('purchasespayment'))?></h3>
<h3><?php echo CHtml::link('Memo Pembelian', Yii::app()->createUrl('purchasesmemo'))?></h3>

<h2>Bagian Penjualan</h2>
<h3><?php echo CHtml::link('Pesanan Pembeli', Yii::app()->createUrl('salesorder'))?></h3>
<h3><?php echo CHtml::link('Pengiriman Barang ke Pelanggan', Yii::app()->createUrl('stockdeliveries/index'))?></h3>
<h3><?php echo CHtml::link('Penerimaan Pembayaran dari Pelanggan', Yii::app()->createUrl('receipts/index'))?></h3>

<h2>Bagian Gudang</h2>
<h3><?php echo CHtml::link('Terima Kiriman dari Pemasok', Yii::app()->createUrl('stockentries'))?></h3>
<h3><?php echo CHtml::link('Input Stok Opname', Yii::app()->createUrl('inputinventorytaking'))?></h3>

<h2>Bagian Keuangan</h2>
<h3><?php echo CHtml::link('Pembayaran Pemasok', Yii::app()->createUrl('financepayment'))?></h3>
<h3><?php echo CHtml::link('Penentuan Harga Pokok Opname', Yii::app()->createUrl('inventorycosting'))?></h3>
