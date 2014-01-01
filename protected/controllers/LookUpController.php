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
   public function actionGetItem($name)
   {
      $data=Yii::app()->db->createCommand()->select('name')->from('items')
              ->where('name like :itemname', array(':itemname'=>'%'.$name.'%'))
              ->order('name')
              ->queryColumn();
      
      if(count($data)) { 
         foreach($data as $key=>$value) {
            $data[$key]=rawurlencode($value);
         }
      } else {
         $data='NA';
      }
      echo json_encode($data);
   }
   
   public function actionGetItemID($name)
   {
      $name=urldecode($name);
      $data=Yii::app()->db->createCommand()->selectDistinct('id')->from('items')
              ->where("name = '$name'")
              ->order('id')
              ->queryScalar();
      echo $data; 
   }
   
   public function actionGetUndonePO($idsupplier)
   {
      $idsupplier=urldecode($idsupplier);
      $data=Yii::app()->db->createCommand()->select('id, regnum')->from('purchasesorders')
         ->where("status <> '2' and idsupplier = :idsupplier", array(':idsupplier'=>$idsupplier))
         ->queryAll();
      echo json_encode($data);
   }
   
   public function actionGetUnsettledPO($idsupplier)
   {
      $idsupplier=urldecode($idsupplier);
      $data=Yii::app()->db->createCommand()->select('id, regnum')->from('purchasesorders')
         ->where("paystatus <> '2' and idsupplier = :idsupplier", array(':idsupplier'=>$idsupplier))
         ->queryAll();
      echo json_encode($data);
   }        
   
   public function actionGetUndoneDO($idsupplier)
   {
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
   }
}
