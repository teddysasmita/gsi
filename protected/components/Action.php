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
   
   public static function decodeDeleteDetailStockDeliveryUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailstockdeliveries/delete', array('iddetail'=>$data['iddetail']));
   }
   
   public static function decodeUpdateDetailStockDeliveryUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailstockdeliveries/update', array('iddetail'=>$data['iddetail']))  ;
   }
   
   public static function decodeViewDetailStockDeliveryUrl($data)
   {
      //return print_r($data);
      return Yii::app()->createUrl('detailstockdeliveries/view', array('iddetail'=>$data['iddetail']));
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
         ->update('purchasesorders', array('status'=>$status), 'id=:id', array(':id'=>$idpo));
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
}

?>
