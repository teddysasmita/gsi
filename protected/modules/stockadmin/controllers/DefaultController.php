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
	select b.iddetail, a.regnum, a.transid, a.idatetime, count(*) as total, b.iditem from stockentries a 
	join detailstockentries b on b.id = a.id
	where b.iditem = :p_b_iditem and a.idwarehouse = :p_a_idwh
	group by a.transid
	union
	select d.iddetail, c.regnum, c.transid, c.idatetime, - (count(*)) as total, d.iditem from stockexits c 
	join detailstockexits d on d.id = c.id
	where d.iditem = :p_d_iditem and c.idwarehouse = :p_c_idwh
	group by c.transid
	order by idatetime							
EOS;
				$iditemparam = $_GET['iditem'];
				$whcodeparam = $_GET['whcode'];
				$idwh = lookup::WarehouseIDFromCode($whcodeparam);
				if ($idwh == FALSE)
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
	
	protected function trackActivity($action)
	{
		$this->tracker=new Tracker();
		$this->tracker->init();
		$this->tracker->logActivity($this->formid, $action);
	}
}