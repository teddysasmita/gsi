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
   
   public function actionGetItemID($name)
   {
		if (!Yii::app()->user->isGuest) {  		
      		$name=urldecode($name);
      		$data=Yii::app()->db->createCommand()->selectDistinct('id')->from('items')
              ->where("name = '$name'")
              ->order('id')
              ->queryScalar();
      		echo $data; 
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
   
   public function actionGetUndonePO($idsupplier)
   {
		if (!Yii::app()->user->isGuest) {
      		$idsupplier=urldecode($idsupplier);
      		$data=Yii::app()->db->createCommand()->select('id, regnum')->from('purchasesorders')
         		->where("status <> '2' and idsupplier = :idsupplier", array(':idsupplier'=>$idsupplier))
         		->queryAll();
      		echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
   
   public function actionGetUnsettledPO($idsupplier)
   {
   		if (!Yii::app()->user->isGuest) {
   			$idsupplier=urldecode($idsupplier);
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
	   		$idsupplier=urldecode($idsupplier);
		   	/*echo Yii::app()->db->createCommand()->select('a.donum, b.id')->from('stockentries a')
		   	->leftJoin('purchasesreceipts b','b.donum = a.donum' )
		   	->where("a.idsupplier = :idsupplier and b.id = NULL", array(':idsupplier'=>$idsupplier))->text;
		   	*/			
		   	$data=Yii::app()->db->createCommand()->select('a.donum, b.id')->from('stockentries a')
		   	->leftJoin('purchasesreceipts b','b.donum = a.donum' )
		   	->where("a.idsupplier = :idsupplier and b.id is NULL", array(':idsupplier'=>$idsupplier))
		   	->queryAll();
		   	
		   	echo json_encode($data);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
   }
}
