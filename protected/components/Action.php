<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of action
 *
 * @author teddy
 */
class Action extends CComponent {
   
   //put your code here
   
	public static function getTransName($id)
	{
		return Yii::app()->db->createCommand()->select('remark')
			->from('information')->where('id = :p_id', array(':p_id'=>$id))
			->queryScalar();
	}
    
	public static function decodePrintStockCardUrl($data)
	{
		//return print_r($data);
		return Yii::app()->createUrl('inventorytaking/default/printstockcard', array('iditem'=>$data['iditem'], 
					'idwarehouse'=>$data['idwarehouse']));
	}
	
    public static function decodeDeleteDetailSalesOrderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/detailsalesorders/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailSalesOrderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/detailsalesorders/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailSalesOrderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/detailsalesorders/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodePrintStockCard2($data)
   {
   		return $data['iditem'].'-'.$data['idwarehouse'];
   	
   }
   
   public static function decodeRestoreHistoryDetailSalesOrderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/detailsalesorders/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreDeletedDetailSalesOrderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/detailsalesorders/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreDeletedSalesorderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/default/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreHistorySalesorderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('salesorder/default/restore', array('idtrack'=>$data['idtrack']));
   }

   public static function decodeUpdateDetailInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/detailinputinventorytakings/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeUpdate2DetailInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/detailinputinventorytakings/update2', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/detailinputinventorytakings/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeRestoreHistoryDetailInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/detailinputinventorytakings/restore', array('idtrack'=>$data['idtrack'], 'iddetail'=>$data['iddetail']));
   }
    
   public static function decodeRestoreDeletedDetailInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/detailinputinventorytakings/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreDeletedInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/default/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
    
   public static function decodeDeleteDetailInputInventoryTakingUrl($data)
   {
   	return Yii::app()->createUrl('inputinventorytaking/detailinputinventorytakings/delete2', array('iddetail'=>$data['iddetail']));	
   	
   }
   
   public static function decodeRestoreHistoryInputInventoryTakingUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('inputinventorytaking/default/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeDeleteDetailSalesInvoiceUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailsalesinvoices/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailSalesInvoiceUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailsalesinvoices/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailSalesInvoiceUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailsalesinvoices/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailPurchasesInvoiceUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailpurchasesinvoices/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPurchaseInvoiceUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailpurchasesinvoices/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailPurchasesInvoiceUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailpurchasesinvoices/view', array('iddetail'=>$data['iddetail']));
   }
      
   public static function decodeDeleteDetailPurchasesOrderUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesorder/detailpurchasesorders/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPurchasesOrderUrl($data, $regnum)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesorder/detailpurchasesorders/update', 
         array('iddetail'=>$data['iddetail'], 'regnum'=>$regnum ));
   }
   
   public static function decodeViewDetailPurchasesOrderUrl($data, $regnum)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesorder/detailpurchasesorders/view', 
         array('iddetail'=>$data['iddetail'], 'regnum'=>$regnum));
   }
   
   public static function decodeDeleteDetailPurchasesOrder2Url($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesorder/detailpurchasesorders2/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPurchasesOrder2Url($data, $regnum)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesorder/detailpurchasesorders2/update', 
         array('iddetail'=>$data['iddetail'], 'regnum'=>$regnum))  ;
   }
   
   public static function decodeViewDetailPurchasesOrder2Url($data, $regnum)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesorder/detailpurchasesorders2/view', 
         array('iddetail'=>$data['iddetail'], 'regnum'=>$regnum));
   }
   
   public static function decodeDeleteDetailPurchaseMemoUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesmemo/detailpurchasesmemos/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPurchaseMemoUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesmemo/detailpurchasesmemos/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailPurchaseMemoUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('purchasesmemo/detailpurchasesmemos/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailStockEntryUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('/stockentries/detailstockentries/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailStockEntryUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('/stockentries/detailstockentries/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailStockEntryUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('/stockentries/detailstockentries/view', array('iddetail'=>$data['iddetail']));
   }
   
	public static function decodeDeleteDetailBarcodePrintUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('/barcodeprint/detailbarcodeprints/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailBarcodePrintUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('/barcodeprint/detailbarcodeprints/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailBarcodePrintUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('/barcodeprint/detailbarcodeprints/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailPurchasesReceiptUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/purchasesreceipt/detailpurchasesreceipts/delete', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeUpdateDetailPurchasesReceiptUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/purchasesreceipt/detailpurchasesreceipts/update', array('iddetail'=>$data['iddetail']))  ;
   }
    
   public static function decodeViewDetailPurchasesReceiptUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/purchasesreceipt/detailpurchasesreceipts/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPurchasesPaymentUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/purchasespayment/detailpurchasespayments/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailPurchasesPaymentUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/purchasespayment/detailpurchasespayments/view', array('iddetail'=>$data['iddetail']));
   }
   

   public static function decodeDeleteDetailStockExitUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/stockexits/detailstockexits/delete', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeUpdateDetailStockExitUrl($data, $idwh)
   {
   	//return Yii::app()->createUrl('/stockexits/detailstockexits/update', array('idwh'=>$idwh));
   	return Yii::app()->createUrl('/stockexits/detailstockexits/update', array('iddetail'=>$data['iddetail'], 'idwh'=>$idwh));
   }
    
   public static function decodeViewDetailStockExitUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('/stockexits/detailstockexits/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailPaymentUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailpayments/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPaymentUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailpayments/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailPaymentUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailpayments/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailReceiptUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailreceipts/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailReceiptUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailreceipts/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailReceiptUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailreceipts/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailItemUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('item/detailitems/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailItemUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('item/detailitems/update', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeRestoreHistoryCustomerUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('customer/default/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreDeletedCustomerUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('customer/default/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreHistorySupplierUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('supplier/default/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreDeletedSupplierUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('supplier/default/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
    
   public static function decodeRestoreHistoryItemUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('item/default/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreDeletedItemUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('item/default/restoreDeleted', array('idtrack'=>$data['idtrack']));
   }
   
   public static function setStatusPO($idpo, $status)
   {
      Yii::app()->db->createCommand()
         ->update('purchasesorders', array('status'=>$status), 'regnum=:id', array(':id'=>$idpo));
   }
   
   public static function setPaymentStatusPO($idpo, $status)
   {
   	Yii::app()->db->createCommand()
   	->update('purchasesorders', array('paystatus'=>$status), 'id=:id', array(':id'=>$idpo));
   }
    
   
   public static function decodeRestoreHistoryWarehouseUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('warehouse/default/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeRestoreHistoryPurchaseMemoUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('warehouse/default/restore', array('idtrack'=>$data['idtrack']));
   }
   
   public static function decodeViewDetailPurchasesStockEntryUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('purchasesstockentries/detailpurchasesstockentries/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailPurchasesStockEntryUrl($data)
   {
   		return Yii::app()->createUrl('purchasesstockentries/detailpurchasesstockentries/update', array('iddetail'=>$data['iddetail']));
   }

   public static function decodeDeleteDetailPurchasesStockEntryUrl($data)
   {
   	return Yii::app()->createUrl('purchasesstockentries/detailpurchasesstockentries/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeViewDetailDeliveryOrderNtUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('deliveryordersnt/detaildeliveryordersnt/view', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeUpdateDetailDeliveryOrderNtUrl($data)
   {
   	return Yii::app()->createUrl('deliveryordersnt/detaildeliveryordersnt/update', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailDeliveryOrderNtUrl($data)
   {
   	return Yii::app()->createUrl('deliveryordersnt/detaildeliveryordersnt/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeViewDetailRequestDisplayUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('requestdisplays/detailrequestdisplays/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailRequestDisplayUrl($data)
   {
   	return Yii::app()->createUrl('requestdisplays/detailrequestdisplays/update', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeDeleteDetailRequestDisplayUrl($data)
   {
   	return Yii::app()->createUrl('requestdisplays/detailrequestdisplays/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeViewDetailDeliveryOrderUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('deliveryorders/detaildeliveryorders/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailDeliveryOrderUrl($data)
   {
   	return Yii::app()->createUrl('deliveryorders/detaildeliveryorders/update', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeDeleteDetailReturStockUrl($data)
   {
   	return Yii::app()->createUrl('returstocks/detailreturstocks/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeViewDetailReturStockUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('returstocks/detailreturstocks/view', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeUpdateDetailReturStock2Url($data)
   {
   	return Yii::app()->createUrl('returstocks/detailreturstocks2/update', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailReturStock2Url($data)
   {
   	return Yii::app()->createUrl('returstocks/detailreturstocks2/delete', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeViewDetailReturStock2Url($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('returstocks/detailreturstocks2/view', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailReturStockUrl($data)
   {
   	return Yii::app()->createUrl('returstocks/detailreturstocks/update', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailDeliveryOrderUrl($data)
   {
   	return Yii::app()->createUrl('deliveryorders/detaildeliveryorders/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeViewDetailOrderRetrievalUrl($data)
   {
   	//return print_r($data);
   	return Yii::app()->createUrl('orderretrievals/detailorderretrievals/view', array('iddetail'=>$data['iddetail']));
   }
    
   public static function decodeUpdateDetailOrderRetrievalUrl($data)
   {
   	return Yii::app()->createUrl('orderretrievals/detailorderretrievals/update', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeDeleteDetailOrderRetrievalUrl($data)
   {
   	return Yii::app()->createUrl('orderretrievals/detailorderretrievals/delete', array('iddetail'=>$data['iddetail']));
   }
   
	public static function decodeUpdateDetailSalesReplaceUrl($data)
	{
		return Yii::app()->createUrl('salesreplace/detailsalesreplace/update', 
			array('iddetail'=>$data['iddetail']));
	}
	
   public static function addFinancePayment($receipientname, $date, $duedate, $amount)
   {
		if (!Yii::app()->user->isGuest) {
   			Yii::app()->db->createCommand()
				->insert('financepayments', array(
				'id'=>idmaker::getCurrentID2(),
				'idatetime'=>$date,
				'receipient'=>$receipientname,
				'method'=>'0',
				'duedate'=>$date,
				'amount'=>$amount,
				'remark'=>'Belum dilaksanakan. Mohon diisi dengan informasi yang diperlukan.',
				'status'=>'0',
				'userlog'=>Yii::app()->user->id,
				'datetimelog'=>idmaker::getDateTime()
			));	
		}  else {
			throw new CHttpException(404,'You have no authorization for this operation.');
        };
   }
   
   public static function entryItemToWarehouse($idwh, $iddetail, $iditem, $serialnum)
   {
   		if (!Yii::app()->user->isGuest) {
			Yii::app()->db->createCommand()
				->insert('wh'.$idwh, array(
					'iddetail'=>$iddetail,
					'iditem'=>$iditem,
					'serialnum'=>$serialnum,
					'avail'=>1,
				));
   		} else {
   			throw new CHttpException(404,'You have no authorization for this operation.');
   		};
   }
   
   public static function exitItemFromWarehouse($idwh, $serialnum)
   {
	   	if (!Yii::app()->user->isGuest) {
	   		Yii::app()->db->createCommand()
	   			->update('wh'.$idwh, array('avail'=>0), 'serialnum = :p_serialnum', array(
	   				':p_serialnum'=>$serialnum
	   			));
	   	} else {
	   		throw new CHttpException(404,'You have no authorization for this operation.');
	   	};
   }
}

?>
