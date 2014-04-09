<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $formid='AC15';
	public $tracker;
	public $state;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
			$this->trackActivity('v');
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
		} else {
        	throw new CHttpException(404,'You have no authorization for this operation.');
        };	
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
             if(Yii::app()->authManager->checkAccess($this->formid.'-Append', 
                    Yii::app()->user->id))  {   
                $this->state='c';
                $this->trackActivity('c');    
                    
                $model=new Stockexits;
                $this->afterInsert($model);
                
                Yii::app()->session['master']='create';
                //as the operator enter for the first time, we load the default value to the session
                if (!isset(Yii::app()->session['Stockexits'])) {
                   Yii::app()->session['Stockexits']=$model->attributes;
                } else {
                // use the session to fill the model
                    $model->attributes=Yii::app()->session['Stockexits'];
                }
                
               // Uncomment the following line if AJAX validation is needed
               $this->performAjaxValidation($model);
				
                if (isset($_POST)){
                   if(isset($_POST['yt0'])) {
                      //The user pressed the button;
                      $model->attributes=$_POST['Stockexits'];
                      
                      
                      $this->beforePost($model);
                      $respond=$this->checkWarehouse($model->idwarehouse);
                      $respond=$respond && $this->checkSerialNum(Yii::app()->session['Detailstockexits']);
                      if ($respond) {
                         $respond=$model->save();
                         if(!$respond) {
                             throw new CHttpException(404,'There is an error in master posting'. ' '. $model->errors);
                         }

                         if(isset(Yii::app()->session['Detailstockexits']) ) {
                           $details=Yii::app()->session['Detailstockexits'];
                           $respond=$respond&&$this->saveNewDetails($details, $model->idwarehouse);
                         } 

                         if($respond) {
                            $this->afterPost($model);
                            Yii::app()->session->remove('Stockexits');
                            Yii::app()->session->remove('Detailstockexits');
                            Yii::app()->session->remove('Deletedetailstockexits');
                            $this->redirect(array('view','id'=>$model->id));
                         } 
                         
                      } else {
                        throw new CHttpException(404,'Nomor Serial telah terdaftar.');
                     }     
                   } else if (isset($_POST['command'])){
                      // save the current master data before going to the detail page
                      if($_POST['command']=='adddetail') {
                         $model->attributes=$_POST['Stockexits'];
                         Yii::app()->session['Stockexits']=$_POST['Stockexits'];
                         $this->redirect(array('detailstockexits/create',
                            'id'=>$model->id));
                      } else if ($_POST['command']=='getPO') {
                         $model->attributes=$_POST['Stockexits'];
                         Yii::app()->session['Stockexits']=$_POST['Stockexits'];
                         $this->loadLPB($model->transid, $model->id, $model->idwarehouse);
                      } else if ($_POST['command']=='updateDetail') {
                         $model->attributes=$_POST['Stockexits'];
                         Yii::app()->session['Stockexits']=$_POST['Stockexits'];
                      }
                   }
                }

                $this->render('create',array(
                    'model'=>$model,
                ));
                
             } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
             }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
          if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
                 Yii::app()->user->id))  {

             $this->state='u';
             $this->trackActivity('u');

             $model=$this->loadModel($id);
             $this->afterEdit($model);
             
             Yii::app()->session['master']='update';

             if(!isset(Yii::app()->session['Stockexits']))
                Yii::app()->session['Stockexits']=$model->attributes;
             else
                $model->attributes=Yii::app()->session['Stockexits'];

             if(!isset(Yii::app()->session['Detailstockexits'])) 
               Yii::app()->session['Detailstockexits']=$this->loadDetails($id);
             
             // Uncomment the following line if AJAX validation is needed
             $this->performAjaxValidation($model);

             if(isset($_POST)) {
                 if(isset($_POST['yt1'])) {
                     $model->attributes=$_POST['Stockexits'];
                     $this->beforePost($model);
                     $this->tracker->modify('stockexits', $id);
                     $respond=$model->save();
                     if($respond) {
                       $this->afterPost($model);
                     } else {
                     	throw new CHttpException(404,'There is an error in master posting ');
                     }

                     if(isset(Yii::app()->session['Detailstockexits'])) {
                         $details=Yii::app()->session['Detailstockexits'];
                         $respond=$respond&&$this->saveDetails($details);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail posting');
                         }
                     };
                     
                     if(isset(Yii::app()->session['Deletedetailstockexits'])) {
                         $deletedetails=Yii::app()->session['Deletedetailstockexits'];
                         $respond=$respond&&$this->deleteDetails($deletedetails);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail deletion');
                         }
                     };
                    
                     if($respond) {
                         Yii::app()->session->remove('Stockexits');
                         Yii::app()->session->remove('Detailstockexits');
                         Yii::app()->session->remove('Deletedetailstockexits');
                         $this->redirect(array('view','id'=>$model->id));
                     }
                 }
             }

             $this->render('update',array(
                     'model'=>$model,
             ));
         }  else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
         if(Yii::app()->authManager->checkAccess($this->formid.'-Delete', 
                 Yii::app()->user->id))  {

            $model=$this->loadModel($id);
            $this->trackActivity('d');
            $this->beforeDelete($model);
            $this->tracker->delete('stockexits', $id);

            $detailmodels=Detailstockexits::model()->findAll('id=:id',array(':id'=>$id));
            foreach($detailmodels as $dm) {
               $this->tracker->init();
               $this->tracker->delete('detailstockexits', array('iddetail'=>$dm->iddetail));
               $dm->delete();
            }

            $model->delete();
            $this->afterDelete($model);

         // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
         if(!isset($_GET['ajax']))
               $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
     }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-List', 
                Yii::app()->user->id)) {
               $this->trackActivity('l');

               Yii::app()->session->remove('Stockexits');
               Yii::app()->session->remove('Detailstockexits');
               Yii::app()->session->remove('Deletedetailstockexits');
               $dataProvider=new CActiveDataProvider('Stockexits',
                  array(
                     'criteria'=>array(
                        'order'=>'id desc'
                     )
                  )
               );
               $this->render('index',array(
                     'dataProvider'=>$dataProvider,
               ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-List', 
                Yii::app()->user->id)) {
                $this->trackActivity('s');
               
                $model=new Stockexits('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stockexits']))
			$model->attributes=$_GET['Stockexits'];

		$this->render('admin',array(
			'model'=>$model,
		));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
	}

         public function actionHistory($id)
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $model=$this->loadModel($id);
                $this->render('history', array(
                   'model'=>$model,
                    
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }   
        }
        
        public function actionDeleted()
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $this->render('deleted', array(
         
                    
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }   
        }
        
        public function actionRestore($idtrack)
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $this->trackActivity('r');
                $this->tracker->restore('stockexits', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Stockexits');
                $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
        }
        
        public function actionRestoreDeleted($idtrack)
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $this->trackActivity('n');
                $this->tracker->restoreDeleted('stockexits', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Stockexits');
                $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
        }
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Stockexits the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Stockexits::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Stockexits $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stockexits-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
      public function actionCreateDetail()
      {
      //this action continues the process from the detail page
         if(Yii::app()->authManager->checkAccess($this->formid.'-Append', 
                 Yii::app()->user->id))  {
             $model=new Stockexits;
             $model->attributes=Yii::app()->session['Stockexits'];

             $details=Yii::app()->session['Detailstockexits'];
             $this->afterInsertDetail($model, $details);
			 
             
             $this->render('create',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         } 
      }
      
      public function actionUpdateDetail()
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
                 Yii::app()->user->id))  {

             $model=new Stockexits;
             $model->attributes=Yii::app()->session['Stockexits'];

             $details=Yii::app()->session['Detailstockexits'];
             $this->afterUpdateDetail($model, $details);

             $this->render('update',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }
      
      public function actionDeleteDetail()
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
                 Yii::app()->user->id))  {


             $model=new Stockexits;
             $model->attributes=Yii::app()->session['Stockexits'];

             $details=Yii::app()->session['Detailstockexits'];
             $this->afterDeleteDetail($model, $details);

             $this->render('update',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }
      

     protected function saveNewDetails(array $details, $idwh)
     {                  
         foreach ($details as $row) {
             $detailmodel=new Detailstockexits;
             $detailmodel->attributes=$row;
             $respond=$detailmodel->insert();
             if (!$respond) {
                break;
             }
             Action::exitItemFromWarehouse($idwh, $row['serialnum']);
         }
         return $respond;
     }
     

     protected function saveDetails(array $details)
     {
         $idmaker=new idmaker();

         $respond=true;
         foreach ($details as $row) {
             $detailmodel=Detailstockexits::model()->findByPk($row['iddetail']);
             if($detailmodel==NULL) {
                 $detailmodel=new Detailstockexits;
             } else {
                 if(count(array_diff($detailmodel->attributes,$row))) {
                     $this->tracker->init();
                     $this->tracker->modify('detailstockexits', array('iddetail'=>$detailmodel->iddetail));
                 }    
             }
             $detailmodel->attributes=$row;
             $detailmodel->userlog=Yii::app()->user->id;
             $detailmodel->datetimelog=$idmaker->getDateTime();
             $respond=$detailmodel->save();
             if (!$respond) {
               break;
             }
          }
          return $respond;
     }
      
     protected function deleteDetails(array $details)
     {
         $respond=true;
         foreach ($details as $row) {
             $detailmodel=Detailstockexits::model()->findByPk($row['iddetail']);
             if($detailmodel) {
                 $this->tracker->init();
                 $this->trackActivity('d', $this->__DETAILFORMID);
                 $this->tracker->delete('detailstockexits', $detailmodel->id);
                 $respond=$detailmodel->delete();
                 if (!$respond) {
                   break;
                 }
             }
         }
         return $respond;
     }


     protected function loadDetails($id)
     {
      $sql="select * from detailstockexits where id='$id'";
      $details=Yii::app()->db->createCommand($sql)->queryAll();

      return $details;
     }


     protected function afterInsert(& $model)
     {
         $idmaker=new idmaker();
         $model->id=$idmaker->getCurrentID2();
         $model->idatetime=$idmaker->getDateTime();
         $model->regnum=$idmaker->getRegNum($this->formid);
         $model->idwarehouse=lookup::WarehouseNameFromIpAddr($_SERVER['REMOTE_ADDR']);
         $model->userlog=Yii::app()->user->id;
         $model->datetimelog=$idmaker->getDateTime();
     }

     protected function afterPost(& $model)
     {
         $idmaker=new idmaker();
         $idmaker->saveRegNum($this->formid, $model->regnum);
         
         $this->setStatusPO($model->transid,
            Yii::app()->session['Detailstockexits']);
     }

     protected function beforePost(& $model)
     {
         $idmaker=new idmaker();

         $model->userlog=Yii::app()->user->id;
         $model->datetimelog=$idmaker->getDateTime();
         $model->regnum=$idmaker->getRegNum($this->formid);
     }

     protected function    beforeDelete(& $model)
     {

     }

     protected function afterDelete(& $model)
     {

     }

     protected function afterEdit(& $model)
     {

     }

     protected function afterInsertDetail(& $model, $details)
     {

     }


     protected function afterUpdateDetail(& $model, $details)
     {

     }

     protected function afterDeleteDetail(& $model, $details)
     {
     }


     protected function trackActivity($action)
     {
         $this->tracker=new Tracker();
         $this->tracker->init();
         $this->tracker->logActivity($this->formid, $action);
     }
     
      private function loadPO($idpo, $id)
      {
        $details=array();

        $dataPO=Yii::app()->db->createCommand()
           ->select('a.id, b.*')
           ->from('purchasesorders a')
           ->join('detailpurchasesorders b', 'b.id=a.id')
           ->where('a.regnum = :p_id', array(':p_id'=>$idpo) )
           ->queryAll();
        Yii::app()->session->remove('Detailstockexits');
        $sql=<<<EOS
    	select count(*) as received from stockexits a 
		join detailstockexits b on b.id = a.id
		where a.transid = :p_transid and b.iditem = :p_iditem and
        b.serialnum <> 'Belum Diterima'   
EOS;
        $mycommand=Yii::app()->db->createCommand($sql);
         foreach($dataPO as $row) {
         	$mycommand->bindParam(':p_transid', $idpo, PDO::PARAM_STR);
         	$mycommand->bindParam(':p_iditem', $row['iditem'], PDO::PARAM_STR);
         	$accepted=$mycommand->queryScalar();
            for ($index = 0; $index < $row['qty'] - $accepted; $index++) {
               $detail['iddetail']=idmaker::getCurrentID2();
               $detail['id']=$id;
               $detail['iditem']=$row['iditem'];
               $detail['userlog']=Yii::app()->user->id;
               $detail['datetimelog']=idmaker::getDateTime();
               $detail['serialnum']='Belum Diterima';

               $details[]=$detail; 
           	}
        }
        Yii::app()->session['Detailstockexits']=$details;
      }
     
      private function loadLPB($nolpb, $id, $idwh)
      {
      	$details=array();
      
      	$dataLPB=Yii::app()->db->createCommand()
	      	->select('a.id, b.*')
	      	->from('deliveryorders a')
	      	->join('detaildeliveryorders b', 'b.id=a.id')
	      	->where('a.regnum = :p_regnum and b.idwarehouse = :p_idwarehouse', 
	      		array(':p_regnum'=>$nolpb, ':p_idwarehouse'=> $idwh) )
	      	->queryAll();
      	if ($dataLPB == FALSE ) {
      		$dataLPB=Yii::app()->db->createCommand()
      			->select('a.id, b.*')
      			->from('requestdisplays a')
      			->join('detailrequestdisplays b', 'b.id=a.id')
      			->where('a.regnum = :p_regnum and b.idwarehouse = :p_idwarehouse',
      				array(':p_regnum'=>$nolpb, ':p_idwarehouse'=> $idwh) )
      				->queryAll();
      	}
      	if ($dataLPB == FALSE ) {
      		$dataLPB=Yii::app()->db->createCommand()
      		->select('a.id, b.*')
      		->from('orderretrievals a')
      		->join('detailorderretrievals b', 'b.id=a.id')
      		->where('a.regnum = :p_regnum and b.idwarehouse = :p_idwarehouse',
      				array(':p_regnum'=>$nolpb, ':p_idwarehouse'=> $idwh) )
      				->queryAll();
      	}
      	
      	$sql=<<<EOS
    	select count(*) as received from stockexits a
		join detailstockexits b on b.id = a.id
		where a.transid = :p_transid and b.iditem = :p_iditem and
        b.serialnum <> 'Belum Diterima'
EOS;
      	$mycommand=Yii::app()->db->createCommand($sql);
      	
      	foreach($dataLPB as $row) {
      		$mycommand->bindParam(':p_transid', $nolpb, PDO::PARAM_STR);
      		$mycommand->bindParam(':p_iditem', $row['iditem'], PDO::PARAM_STR);
			$accepted=$mycommand->queryScalar();
			for ($index = 0; $index < $row['qty'] - $accepted; $index++) {
				$detail['iddetail']=idmaker::getCurrentID2();
      			$detail['id']=$id;
				$detail['iditem']=$row['iditem'];
				$detail['userlog']=Yii::app()->user->id;
				$detail['datetimelog']=idmaker::getDateTime();
				$detail['serialnum']='Belum Diterima';
      			$details[]=$detail;
			}
		}
		Yii::app()->session->remove('Detailstockexits');
		Yii::app()->session['Detailstockexits']=$details;
	}
      			
      private function checkSerialNum(array $details ) 
      {
         $respond=true;
         
         foreach($details as $detail) {
            if ($detail['serialnum'] !== 'Belum Diterima') {
               $count=Yii::app()->db->createCommand()
                  ->select('count(*)')
                  ->from('detailstockexits')
                  ->where("serialnum = :serialnum", array(':serialnum'=>$detail['serialnum']))
                  ->queryScalar();
               $respond=$count==0;
               if(!$respond)
                  break;
            };
         }   
         return $respond;
      }
      
      private function setStatusPO($idpo, array $details)
      {
         $complete=true;
         $partial=false;
         foreach($details as $detail) {
            if($detail['serialnum'] !== 'Belum Diterima')
               $partial=true;
            if($detail['serialnum']=='Belum Diterima') 
               $complete=false;
         }
         if(!$complete && !$partial)
            $status='0';
         if(!$complete && $partial)
            $status='1';
         if($complete && $partial)
            $status='2';
         Action::setStatusPO ($idpo, $status);
      }
      
      private function checkWarehouse($idwarehouse)
      {
         $respond=$idwarehouse<>'NA';
         if (!$respond)
           throw new CHttpException(404,'Gudang belum terdaftar.'); 
         else
            return $respond; 
      }
      
      public function actionSummary($id)
      {
      	$this->trackActivity('v');
      	$this->render('summary',array(
      			'model'=>$this->loadModel($id),
      	));
      
      }
      
      public function actionPrintsummary($id)
      {
      	$this->trackActivity('v');
      	Yii::import("application.vendors.tcpdf.*");
      	require_once('tcpdf.php');
      	$this->render('printsummary',array(
      			'model'=>$this->loadModel($id),
      	));
      	
      }
      
}