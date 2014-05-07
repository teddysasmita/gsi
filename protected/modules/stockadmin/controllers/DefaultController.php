<?php

function cmp($a, $b)
{
	return strcmp($a['iditem'], $b['iditem']);
}

function cmp2($a, $b)
{
	return strcmp($a['idatetime'], $b['idatetime']);
}

class DefaultController extends Controller
{
	private $formid = 'AC51';
	private $tracker;
	
	public function actionIndex()
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
			$this->render('index');
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionQuantity()
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
			
			$alldata = array();
			$whcodeparam = '';
			$itemnameparam = '';
				
			if (isset($_GET['go'])) {
				$whcodeparam = $_GET['whcode'];
				$itemnameparam = $_GET['itemname'];
				$whs = Yii::app()->db->createCommand()
					->select("id, code")->from('warehouses')->where('code like :p_code', 
						array(':p_code'=>'%'.$whcodeparam.'%'))
					->queryAll();	
				foreach($whs as $wh) {
					$data = Yii::app()->db->createCommand()
						->select("count(*) as total, a.iddetail, a.iditem, b.name, '${wh['code']}' as code")
						->from("wh${wh['id']} a")
						->join('items b', 'b.id = a.iditem')
						->where("b.name like :p_name and a.avail = '1'", array(':p_name'=>"%$itemnameparam%"))	
						->group(array('iditem'))
						->order('iditem')
						->queryAll();
					$alldata = array_merge($alldata, $data);
				}
				usort($alldata, 'cmp');
			}
			$this->render('quantity', array('alldata'=>$alldata, 'whcode'=>$whcodeparam, 'itemname'=>$itemnameparam));
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionSerial()
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
				
			$alldata = array();
			$whcodeparam = '';
			$itemnameparam = '';
			
			if (isset($_GET['go'])) {
				$whcodeparam = $_GET['whcode'];
				$itemnameparam = $_GET['itemname'];
				$whs = Yii::app()->db->createCommand()
				->select("id, code")->from('warehouses')->where('code like :p_code',
						array(':p_code'=>'%'.$whcodeparam.'%'))
						->queryAll();
				foreach($whs as $wh) {
					$data = Yii::app()->db->createCommand()
					->select("a.iddetail, a.iditem, b.name, a.serialnum, concat('${wh['code']}') as code")
					->from("wh${wh['id']} a")
					->join('items b', 'b.id = a.iditem')
					->where("b.name like :p_name and a.avail = '1'", array(':p_name'=>"%$itemnameparam%"))
					->order('b.name')
					->queryAll();
					$alldata = array_merge($alldata, $data);
				}
				usort($alldata, 'cmp');
			}
			$this->render('serial', array('alldata'=>$alldata, 'whcode'=>$whcodeparam, 'itemname'=>$itemnameparam));
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionFlow()
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
		
			$alldata = array();
			$iditemparam = '';
			$whcodeparam = '';
				
			if (isset($_GET['go'])) {
				$sql=<<<EOS
	select b.iddetail, a.idwarehouse, a.regnum, a.transid, a.idatetime, count(*) as total, b.iditem from stockentries a 
	join detailstockentries b on b.id = a.id
	where b.iditem = :p_b_iditem and a.idwarehouse like :p_a_idwh
	group by a.transid
	union
	select d.iddetail, c.idwarehouse, c.regnum, c.transid, c.idatetime, - (count(*)) as total, d.iditem from stockexits c 
	join detailstockexits d on d.id = c.id
	where d.iditem = :p_d_iditem and c.idwarehouse like :p_c_idwh
	group by c.transid
	order by idatetime							
EOS;
				$iditemparam = $_GET['iditem'];
				$whcodeparam = $_GET['whcode'];
				if ($whcodeparam !== "")
					$idwh = lookup::WarehouseIDFromCode($whcodeparam);
				else
					$idwh = '%';
				$command = Yii::app()->db->createCommand($sql);
				$command->bindParam(':p_b_iditem', $iditemparam, PDO::PARAM_STR);
				$command->bindParam(':p_d_iditem', $iditemparam, PDO::PARAM_STR);
				$command->bindParam(':p_a_idwh', $idwh, PDO::PARAM_STR);
				$command->bindParam(':p_c_idwh', $idwh, PDO::PARAM_STR);
				$alldata = $command->queryAll();
				usort($alldata, 'cmp2');
			}
			$this->render('flow', array('alldata'=>$alldata, 'iditem'=>$iditemparam, 'whcode'=>$whcodeparam));
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionIndexError()
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
			
			$dataProvider=new CActiveDataProvider('Errors',
                  array(
                     'criteria'=>array(
                        'order'=>'id desc'
                     )
                  )
               );
			
			$this->render('indexerror', array('dataProvider'=>$dataProvider));
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		};
	}
	
	public function actionViewError($id)
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
			$this->render('viewerror',array(
				'model'=>$this->loadError($id),
			));
		} else {
        	throw new CHttpException(404,'You have no authorization for this operation.');
        };
	}
	
	public function actionErrorExcel($id)
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-Append',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
			
			$xl = new PHPExcel();
			$xl->getProperties()->setCreator("Program GSI Malang")
				->setLastModifiedBy("Program GSI Malang")
				->setTitle("Laporan Penjualan")
				->setSubject("Laporan Penjualan")
				->setDescription("Laporan Penjualan Bulanan")
				->setKeywords("Laporan Penjualan")
				->setCategory("Laporan");	
			$enddate=$enddate.' 23:59:59';
			$datas=Yii::app()->db->createCommand()
				->select()->from('detailerrors a')
				->where('id = :p_id', array(':p_id'=>$id))
				->queryAll();
			foreach ($datas as $data) {
				$newdata['iditem'] = $data['iditem'];
				$newdata['itemname'] = lookup::ItemNameFromItemID($data['iditem']);
				$newdata['serialnum'] = $data['serialnum'];
				$temp = explode('-', $data['remark']);
				$newdata['wh'] = lookup::WarehouseNameFromWarehouseID(trim($temp[2]));
				$newdata['regnum'] = trim($temp[0]);
				$newdatas[] = $newdata;
			}
			$headersname = array( 'ID Barang', 'Nama Barang', 'Nomor Serial', 'Gudang', 'Nomor Urut');
			$headersfield = array('iditem', 'itemname', 'serialnum', 'wj', 'regnum');
			for( $i=0;$i<count($headersname); $i++ ) {
				$xl->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow($i,1, $headersname[$i]);
			}			
			
			for( $i=0; $i<count($data); $i++){
				for( $j=0; $j<count($headersfield); $j++ ) {
					$cellvalue = $data[$i][$headersfield[$j]];
					$xl->setActiveSheetindex(0)
						->setCellValueByColumnAndRow($j,$i+2, $cellvalue);
				}
			}
			
			$xl->getActiveSheet()->setTitle('Laporan Error');
			$xl->setActiveSheetIndex(0);
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="stock-error-report-'.idmaker::getDateTime().'.xlsx"');
			header('Cache-Control: max-age=0');
			$xlWriter = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
			$xlWriter->save('php://output');
		} else {
            throw new CHttpException(404,'You have no authorization for this operation.');
         };
	}
	
	public function loadError($id)
	{
		$model=Errors::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function trackActivity($action)
	{
		$this->tracker=new Tracker();
		$this->tracker->init();
		$this->tracker->logActivity($this->formid, $action);
	}
}