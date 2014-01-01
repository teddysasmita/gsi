<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lookup
 *
 * @author teddy
 */
class lookup extends CComponent {
   //put your code here
   
   public static function orderStatus($stat)
   {
      switch ($stat) {
         case '0':
            return 'Belum Diproses';
         case '1':
            return 'Diproses Sebagian';
         case '2':
            return 'Selesai Diproses';
            
      }
   }
   
   public static function reverseOrderStatus($wstat)
   {
      switch ($wstat) {
         case 'Belum Diproses':
            return '0';
         case 'Telah Diproses':
            return '1';
      }
   }
   
   public static function invoiceStatus($stat)
   {
      switch ($stat) {
         case '0':
            return 'Belum Dibayar';
         case '1':
            return 'Dibayar Sebagian';
         case '2':
            return 'Dibayar Lunas';
      }
   }
   
   public static function reverseInvoiceStatus($wstat)
   {
      switch ($wstat) {
         case 'Belum Dibayar':
            return '0';
         case 'Dibayar Sebagian':
            return '1';
         case 'Dibayar Lunas':
            return '2';
      }
   }
   
   public static function paymentStatus($status)
   {
   	switch ($status) {
	   	case '0':
	   		return 'Belum Diproses';
	   	case '1':
	   		return 'Terbayar dgn Tunai';
	   	case '2':
	   		return 'Terbayar dgn Transfer';
	   	case '3':
	   		return 'Terbayar dgn Cek/Giro';
   	}
   }
   
   public static function activeStatus($status)
   {
   		switch ($status) {
   			case '0':
   				return 'Tidak Aktif';
   			case '1':
   				return 'Aktif';
   		}   
   }
   public static function ItemNameFromItemID($id)
   {
      $sql="select name from items where id='$id'";
      return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function UserNameFromUserID($id)
   {
      $sql="select fullname from users where id='$id'";
      return Yii::app()->authdb->createCommand($sql)->queryScalar();
   }
   
   public static function SalesInvoiceNumFromInvoiceID($id)
   {
      $sql="select regnum from salesinvoices where id='$id'";
      return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function PurchasesInvoiceNumFromInvoiceID($id)
   {
      $sql="select regnum from purchasesinvoices where id='$id'";
      return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function PurchasesOrderNumFromID($id)
   {
      $sql="select regnum from purchasesorders where id='$id'";
      return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function CustomerNameFromCustomerID($id)
   {
      $sql="select concat(firstname, ' ', lastname) as name from customers where id='$id'";
      return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function SupplierNameFromSupplierID($id)
   {
      $sql="select concat(firstname, ' ', lastname) as name from suppliers where id='$id'";
      return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function WarehouseNameFromWarehouseID($id)
   {
      $sql="select code as name from warehouses where id='$id'";
      $name=Yii::app()->db->createCommand($sql)->queryScalar();
      if(!$name) {
         return 'Tidak Terdaftar';
      } else
         return $name;
   }
   
   public static function WarehouseNameFromIpAddr($ipaddr)
   {
      $sql="select id from warehouses where ipaddr='$ipaddr'";
      $name=Yii::app()->db->createCommand($sql)->queryScalar();
      if(!$name) {
         return 'NA';
      } else
         return $name;
   }
   
   public static function TypeToName($type)
   {
      switch ($type) {
         case 1:
            return 'Tunggal';
         case 2:
            return 'Paket';
         case 3:
            return 'Jasa';
      } 
   }
}


?>
