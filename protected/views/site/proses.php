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
<h3><?php echo CHtml::link('Tagihan dari Pemasok', Yii::app()->createUrl('purchasesinvoices/index'))?></h3>
<h3><?php echo CHtml::link('Penerimaan Barang dari Pemasok', Yii::app()->createUrl('purchasesreceipt'))?></h3>
<h3><?php echo CHtml::link('Pembayaran ke Pemasok', Yii::app()->createUrl('payments/index'))?></h3>
<h3><?php echo CHtml::link('Memo Pembelian', Yii::app()->createUrl('purchasesmemo'))?></h3>

<h2>Bagian Penjualan</h2>
<h3><?php echo CHtml::link('Pesanan Pembeli', Yii::app()->createUrl('salesorder'))?></h3>
<h3><?php echo CHtml::link('Tagihan ke Pembeli', Yii::app()->createUrl('salesinvoices/index'))?></h3>
<h3><?php echo CHtml::link('Pengiriman Barang ke Pelanggan', Yii::app()->createUrl('stockdeliveries/index'))?></h3>
<h3><?php echo CHtml::link('Penerimaan Pembayaran dari Pelanggan', Yii::app()->createUrl('receipts/index'))?></h3>

<h2>Bagian Gudang</h2>
<h3><?php echo CHtml::link('Terima Kiriman dari Pemasok', Yii::app()->createUrl('stockentries'))?></h3>
