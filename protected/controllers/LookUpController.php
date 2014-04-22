<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LookUpController
 *
 * @author teddy
 */
class LookUpController extends Controller {
   //put your code here
   
	public function actionGetModel($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()->selectDistinct('model')->from('items')
			->where('model like :p_model', array(':p_model'=>'%'.$term.'%'))
			->order('model')
			->queryColumn();
			if(count($data)) {
				foreach($data as $key=>$value) {
					//$data[$key]=rawurlencode($value);
					$data[$key]=$value;
				}
			} else
				$data[0]='NA';
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
        };
		
	}	
	
	public function actionGetBrand($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()->selectDistinct('brand')->from('items')
			->where('brand like :p_brand', array(':p_brand'=>'%'.$term.'%'))
			->order('brand')
			->queryColumn();
			if(count($data)) {
				foreach($data as $key=>$value) {
					//$data[$key]=rawurlencode($value);
					$data[$key]=$value;
				}
			} else
				$data[0]='NA';
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};	
	}
	
	public function actionGetObjects($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()->selectDistinct('objects')->from('items')
				->where('objects like :p_objects', array(':p_objects'=>'%'.$term.'%'))
				->order('objects')
				->queryColumn();
			if(count($data)) {
				foreach($data as $key=>$value) {
					//$data[$key]=rawurlencode($value);
					$data[$key]=$value;
				}
			} else
				$data[0]='NA';
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
        };
	}
	
	public function actionGetItemName($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()->selectDistinct('name')->from('items')
			->where('name like :p_name', array(':p_name'=>'%'.$term.'%'))
			->order('name')
			->queryColumn();
			if(count($data)) {
				foreach($data as $key=>$value) {
					//$data[$key]=rawurlencode($value);
					$data[$key]=$value;
				}
			} else
				$data[0]='NA';
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionGetSalesName($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()
				->select('concat(firstname, \' \', lastname) as nama')->from('salespersons')
				->where('firstname like :p_firstname or lastname like :p_lastname', 
						array(':p_firstname'=>'%'.$term.'%', ':p_lastname'=>'%'.$term.'%'))
				->order('nama')
				->queryColumn();
			if(count($data)) {
				foreach($data as $key=>$value) {
					//$data[$key]=rawurlencode($value);
					$data[$key]=$value;
				}
			} else
				$data[0]='NA';
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionGetSalesID($name)
	{
		if (!Yii::app()->user->isGuest) {
			//print_r($name);
			$name=rawurldecode($name);
			list($firstname, $lastname) = explode(' ', $name);
			$data=Yii::app()->db->createCommand()->selectDistinct('id')->from('salespersons')
			->where("firstname = :p_firstname or lastname = :p_lastname", 
				array(':p_firstname'=> $firstname, ':p_lastname'=>$lastname))
			->order('id')
			->queryScalar();
			echo $data;
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	
	public function actionGetWareHouse($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()->selectDistinct('code')->from('warehouses')
			->where('code like :p_code', array(':p_code'=>'%'.$term.'%'))
			->order('code')
			->queryColumn();
			if(count($data)) {
				foreach($data as $key=>$value) {
					//$data[$key]=rawurlencode($value);
					$data[$key]=$value;
				}
			} else
				$data[0]='NA';
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
   public function actionGetItem($name)
   {
		if (!Yii::app()->user->isGuest) {
	   		$data=Yii::app()->db->createCommand()->selectDistinct('name')->from('items')
	              ->where('name like :itemname', array(':itemname'=>'%'.$name.'%'))
	              ->order('name')
	              ->queryColumn();
	      
	      	if(count($data)) { 
	         	foreach($data as $key=>$value) {
	            	$data[$key]=rawurlencode($value);
	         	}
	      	} else {
	         $data[0]='NA';
	      	}
	      	echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
   
   public function actionGetItem2($term)
   {
   	if (!Yii::app()->user->isGuest) {
   		$data=Yii::app()->db->createCommand()
   		->select('name as label, id as value')
   		->from('items')
   		->where('name like :p_name',
   				array(':p_name'=>"%$term%"))
   				->queryAll();
   		/*echo Yii::app()->db->createCommand()->select('a.donum, b.id')->from('stockentries a')
   		 ->leftJoin('purchasesreceipts b','b.donum = a.donum' )
   		->where("a.idsupplier = :idsupplier and b.id = NULL", array(':idsupplier'=>$idsupplier))->text;
   		*/
   		echo json_encode($data);
   	} else {
   		throw new CHttpException(404,'You have no authorization for this operation.');
   	};
   }
   
	public function actionGetItemPrice($iditem)
   	{
		if (!Yii::app()->user->isGuest) {
	   		$data=Yii::app()->db->createCommand()->select('normalprice')->from('sellingprices')
	              ->where('iditem = :p_iditem', array(':p_iditem'=>$iditem))
	              ->order('idatetime desc')
	              ->queryScalar();
	      
	      	if($data==FALSE) { 
	           $data=-1;
	      	}
	      	echo $data;
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
   
   public function actionGetItemID($name)
   {
		if (!Yii::app()->user->isGuest) {  	
			//print_r($name);	
      		$name=rawurldecode($name);
      		$data=Yii::app()->db->createCommand()->selectDistinct('id')->from('items')
              ->where("name = '$name'")
              ->order('id')
              ->queryScalar();
      		echo $data; 
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
   
   public function actionGetWareHouseID($name)
   {
   	if (!Yii::app()->user->isGuest) {
   		//print_r($name);
   		$name=rawurldecode($name);
   		$data=Yii::app()->db->createCommand()->select('id')->from('warehouses')
   		->where("code = '$name'")
   		->order('id')
   		->queryScalar();
   		echo json_encode($data);
   	} else {
   		throw new CHttpException(404,'You have no authorization for this operation.');
   	};
   }
   
   public function actionGetUndonePO($idsupplier)
   {
		if (!Yii::app()->user->isGuest) {
      		$idsupplier=rawurldecode($idsupplier);
      		$data=Yii::app()->db->createCommand()->select('id, regnum')->from('purchasesorders')
         		->where("status <> '2' and idsupplier = :p_idsupplier", array(':p_idsupplier'=>$idsupplier))
         		->queryAll();
      		echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
   
   public function actionGetUnsettledPO($idsupplier)
   {
   		if (!Yii::app()->user->isGuest) {
   			$idsupplier=rawurldecode($idsupplier);
      		$data=Yii::app()->db->createCommand()->select('id, regnum')->from('purchasesorders')
         		->where("paystatus <> '2' and idsupplier = :idsupplier", array(':idsupplier'=>$idsupplier))
         		->queryAll();
      		echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }        
   
   public function actionGetUndoneDO($idsupplier)
   {
   		if (!Yii::app()->user->isGuest) {	   	
	   		$idsupplier=rawurldecode($idsupplier);
		   	/*echo Yii::app()->db->createCommand()->select('a.donum, b.id')->from('stockentries a')
		   	->leftJoin('purchasesreceipts b','b.donum = a.donum' )
		   	->where("a.idsupplier = :idsupplier and b.id = NULL", array(':idsupplier'=>$idsupplier))->text;
		   	*/			
		   	$data=Yii::app()->db->createCommand()->select('a.donum, c.id')
		   		->from('stockentries a')
		   		->join('purchasesorders b', 'b.regnum = a.transid')
		   		->leftJoin('purchasesreceipts c','c.donum = a.donum' )
		   		->where("b.idsupplier = :p_idsupplier and c.id is NULL",
      				array(':p_idsupplier' => $idsupplier))
		   		->queryAll();
		   	
		   	echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
   
	public function actionGetUserOperation($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->authdb->createCommand()
				->select('description as label, name as value')
				->from('AuthItem')
				->where('type=:p_type and description like :p_desc', 
     				array(':p_type'=>'0', ':p_desc'=>"%$term%"))
				->queryAll();
   		/*echo Yii::app()->db->createCommand()->select('a.donum, b.id')->from('stockentries a')
   		 ->leftJoin('purchasesreceipts b','b.donum = a.donum' )
   		->where("a.idsupplier = :idsupplier and b.id = NULL", array(':idsupplier'=>$idsupplier))->text;
   		*/   		   
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
   		};
	}
   
	public function actionGetUserTask($term)
 	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->authdb->createCommand()
   				->select('description as label, name as value')
   				->from('AuthItem')
   				->where('type=:p_type and description like :p_desc',
   					array(':p_type'=>'1', ':p_desc'=>"%$term%"))
   				->queryAll();
		echo json_encode($data);
   		} else {
   			throw new CHttpException(404,'You have no authorization for this operation.');
   		};
	}
 
	public function actionGetUserRole($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->authdb->createCommand()
			->select('description as label, name as value')
			->from('AuthItem')
			->where('type=:p_type and description like :p_desc',
					array(':p_type'=>'2', ':p_desc'=>"%$term%"))
					->queryAll();
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionGetTrans($id)
	{
		if (!Yii::app()->user->isGuest) {
			$sql=<<<EOS
			select a.id, a.regnum,
			concat( 'Penerimaan Barang - ', b.firstname, ' ', b.lastname, ' - ', a.idatetime) as transinfo,
			'AC12' as transname
			from purchasesstockentries a
			join suppliers b on b.id = a.idsupplier
			where regnum=:p_regnum
EOS;
			$command=Yii::app()->db->createCommand($sql);
			$command->bindParam(':p_regnum', $id, PDO::PARAM_STR);
			$data=$command->queryAll();
			
			if ($data == FALSE) {
				$sql=<<<EOS
				select a.id, a.regnum, a.invnum,
				concat( 'Pengiriman Barang - ', a.invnum, ' - ', a.receivername, ' - ', a.idatetime) as transinfo,
				'AC13' as transname
				from deliveryorders a
				where regnum=:p_regnum
EOS;
				$command=Yii::app()->db->createCommand($sql);
				$command->bindParam(':p_regnum', $id, PDO::PARAM_STR);
				$data=$command->queryAll();
			}
			
			if ($data == FALSE) {
				$sql=<<<EOS
				select a.id, a.regnum, 'NA' as invnum,
				concat( 'Permintaan Barang Display - NA - ', concat(b.firstname, ' ', b.lastname), 
					' - ', a.idatetime) as transinfo,
				'AC16' as transname
				from requestdisplays a
				join salespersons b on b.id = a.idsales
				where regnum=:p_regnum
EOS;
				$command=Yii::app()->db->createCommand($sql);
				$command->bindParam(':p_regnum', $id, PDO::PARAM_STR);
				$data=$command->queryAll();
			}
			
			if ($data == FALSE) {
				$sql=<<<EOS
				select a.id, a.regnum, a.invnum,
				concat( 'Pengambilan Barang Pembeli - ',a.invnum,' - ', a.receivername, ' - ', a.idatetime) as transinfo,
				'AC19' as transname
				from orderretrievals a 
				where regnum=:p_regnum
EOS;
				$command=Yii::app()->db->createCommand($sql);
				$command->bindParam(':p_regnum', $id, PDO::PARAM_STR);
				$data=$command->queryAll();
			}
			
			if ($data == FALSE) {
				$sql=<<<EOS
				select a.id, a.regnum, '-' as invnum,
				concat( 'Pengembalian Barang ke Pemasok - ', a.regnum,' - ', concat(c.firstname, ' ', c.lastname), ' - ', a.idatetime) as transinfo,
				'AC50' as transname
				from returstocks a
				join detailreturstocks b on b.id = a.id
				join suppliers c on c.id = a.idsupplier
				where a.regnum=:p_regnum
EOS;
				$command=Yii::app()->db->createCommand($sql);
				$command->bindParam(':p_regnum', $id, PDO::PARAM_STR);
				$data=$command->queryAll();
			}
			
			if ($data == FALSE) {
				$sql=<<<EOS
				select a.id, a.regnum, 'NA' as invnum,
				concat( 'Pemindahan Barang - NA - ', b.code, ' - ', a.idatetime) as transinfo,
				'AC18' as transname
				from itemtransfers a
				join warehouses b on b.id = a.idwhsource
				where a.regnum=:p_regnum
EOS;
				$command=Yii::app()->db->createCommand($sql);
				$command->bindParam(':p_regnum', $id, PDO::PARAM_STR);
				$data=$command->queryAll();
			}
			
			if ($data !== FALSE)
				echo json_encode($data);
			else 
				echo json_encode(array(array('id'=>'NA')));
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionGetBankName($term)
	{
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()
			->select('name')
			->from('salesposbanks')
			->where('name like :p_name',
					array(':p_name'=>"%$term%"))
					->queryColumn();
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
		
	}
	
	public function actionGetBankID($name)
	{
		$name=rawurldecode($name);
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()
			->select('id')
			->from('salesposbanks')
			->where('name = :p_name',
					array(':p_name'=>$name))
					->queryScalar();
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	
	}
	
	public function actionCheckItemSerial($iditem, $serialnum, $idwh)
	{
		$iditem=rawurldecode($iditem);
		$serialnum=rawurldecode($serialnum);
		
		if (!Yii::app()->user->isGuest) {
			$data=Yii::app()->db->createCommand()
				->select('count(*) as total')
				->from('stockentries a')
				->join('detailstockentries b', 'b.id = a.id')
				->where('b.iditem = :p_iditem and b.serialnum = :p_serialnum and a.idwarehouse = :p_idwh',
					array(':p_iditem'=>$iditem, ':p_serialnum'=>$serialnum, ':p_idwh'=>$idwh))
				/*->where('b.iditem = :p_iditem and b.serialnum = :p_serialnum',
					array(':p_iditem'=>$iditem, ':p_serialnum'=>$serialnum))*/
				->queryScalar();
			if ($data == FALSE) {
				$data=Yii::app()->db->createCommand()
					->select('count(*) as total')
					->from('wh'.$idwh.' a')
					->where('a.iditem = :p_iditem and a.serialnum = :p_serialnum',
						array(':p_iditem'=>$iditem, ':p_serialnum'=>$serialnum))
					/*->where('a.iditem = :p_iditem and a.serialnum = :p_serialnum',
				 		array(':p_iditem'=>$iditem, ':p_serialnum'=>$serialnum))*/
						->queryScalar();
				//$data = 1;
			}
			echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	
	}
}
