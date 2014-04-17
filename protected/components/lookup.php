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
   
   public static function SalesPersonNameFromID($id)
   {
   	$sql="select concat(firstname, ' ', lastname) as name from salespersons where id='$id'";
   	return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function InventoryTakingLabelFromID($id)
   {
   	$sql="select operationlabel from inventorytakings where id='$id'";
   	return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function UserNameFromUserID($id)
   {
      $sql="select fullname from users where id='$id'";
      return Yii::app()->authdb->createCommand($sql)->queryScalar();
   }
   
   public static function UserIDFromName($name)
   {
		if(strlen($name)>0)
			$name='%'.$name.'%';
		$sql="select id from users where fullname like '$name'";
		$data=Yii::app()->authdb->createCommand($sql)->queryScalar();
   	
		if($data===false)
   			return '';
   		else
   			return $data;
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
   
   public static function SalesNameFromID($id)
   {
   	$sql="select concat(firstname, ' ', lastname) as name from salespersons where id='$id'";
   	return Yii::app()->db->createCommand($sql)->queryScalar();
   }
   
   public static function SupplierIDFromLastName($name)
   {
   		if(strlen($name)>0) {
   			$name='%'.$name.'%';
   		} else
   			$name='%';
   		$data=Yii::app()->db->createCommand()
   			->select('id')->from('suppliers')->where("lastname like :boom", array(':boom'=>$name))
			->queryScalar();
		
		if($data==false)
			return 'NAN';
   		else
   			return $data;
   }
   public static function SupplierIDFromFirstName($name)
	{	
		if(strlen($name)>0) {
			$name='%'.$name.'%';
		} else
			$name='%';
	   	$data=Yii::app()->db->createCommand()
			->select('id')->from('suppliers')->where("firstname like :boom", array(':boom'=>$name))
			->queryScalar();
	   	
   		if($data==false)
   			return 'NAN';
   		else
   			return $data;	
	   	/*
   	for($i=1; $i<count($suppliername)-1; $i++) {
   		$command->bindParam(2, $suppliername[$i]);
		$data=$command->queryColumn();
		print_r($data);
		die();
		if (count($data)==1)
			break;
   	};
   	if (count($data)>0)
		return $data[0];
   	else
   		return '';
   	*/	
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
   
   public static function BankNameFromID($id)
   {
   	$sql="select name from salesposbanks where id='$id'";
   	$name=Yii::app()->db->createCommand($sql)->queryScalar();
   	if(!$name) {
   		return 'NA';
   	} else
   		return $name;
   }
   
   public static function CardType($symbol)
   {
   		switch ($symbol) {
   		case 'KK':
   			return 'Kartu Kredit';
   		case 'KD':
   			return 'Kartu Debit';
   		}	
   }
   
   public static function SalesreplaceNameFromCode($code)
   {
   		switch ($code) {
   			case '0':
   				return 'Tetap';
   			case '1':
   				return 'Dirubah';
   			case '2':
   				return 'Dihapus';
   		} 
   }
   
   public static function GetSupplierNameFromSerialnum($serialnum)
   {
   		return Yii::app()->db->createCommand()->select("concat(d.firstname, ' ', d.lastname) as suppliername")
   			->from('detailstockentries a')
   			->join('stockentries b', 'a.id = b.id')
   			->join('purchasesstockentries c', 'c.regnum = b.transid')
   			->join('suppliers d', 'd.id = c.idsupplier')
   			->where('a.serialnum = :p_serialnum', array(':p_serialnum'=>$serialnum))
   			->queryScalar();
   }

   public static function OwnerNameFromCode($code)
   {
   	switch ($code) {
   		case '0':
   			return 'Ibu Linda T';
   		case '1':
   			return 'Bp Welly T';
   		case '2':
   			return 'Bp Sandy T';
   		case '3':
   			return 'Ibu Vera T';
   	}
   }
}


?>
