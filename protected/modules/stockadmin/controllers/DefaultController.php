<?php

function cmp($a, $b)
{
	return strcmp($a['iditem'], $b['iditem']);
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
	
	protected function trackActivity($action)
	{
		$this->tracker=new Tracker();
		$this->tracker->init();
		$this->tracker->logActivity($this->formid, $action);
	}
}