<?php

function cmp($a, $b)
{
	return strcmp($a['iditem'], $b['iditem']);
}

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $formid='AC36';
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
			$this->state='create';
			$this->trackActivity('c');    
                    
			$model=new Changeserialnum;
			$this->afterInsert($model);
                
			Yii::app()->session['master']='create';
                //as the operator enter for the first time, we load the default value to the session
			if (!isset(Yii::app()->session['Changeserialnum'])) {
				Yii::app()->session['Changeserialnum']=$model->attributes;
			} else {
                // use the session to fill the model
				$model->attributes=Yii::app()->session['Changeserialnum'];
			}
                
               // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);
				
			if (isset($_POST)){
				if(isset($_POST['yt1'])) {
                      //The user pressed the button;
					$model->attributes=$_POST['Changeserialnum'];
                      
                      
					$this->beforePost($model);
					$respond=$model->save();
					if(!$respond) 
						throw new CHttpException(404,'There is an error in master posting: '. print_r($model->errors));

					$this->afterPost($model);
					Yii::app()->session->remove('Changeserialnum');
					$this->redirect(array('view','id'=>$model->id));
                         
				} else if (isset($_POST['command'])){
                      // save the current master data before going to the detail page
                   	$model->attributes=$_POST['Changeserialnum'];
                   	Yii::app()->session['Changeserialnum']=$_POST['Changeserialnum'];
                   	if($_POST['command'] == 'setitemserial') {
                         $model->attributes = $_POST['Changeserialnum'];
                         $details = $this->searchItem($model);
                         Yii::app()->session['Detailchangeserialnum'] = $details;
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

             $this->state='update';
             $this->trackActivity('u');

             $model=$this->loadModel($id);
             $this->afterEdit($model);
             
             Yii::app()->session['master']='update';

             if(!isset(Yii::app()->session['Changeserialnum']))
                Yii::app()->session['Changeserialnum']=$model->attributes;
             else
                $model->attributes=Yii::app()->session['Changeserialnum'];

                          // Uncomment the following line if AJAX validation is needed
             $this->performAjaxValidation($model);

             if(isset($_POST)) {
                 if(isset($_POST['yt0'])) {
					$model->attributes=$_POST['Changeserialnum'];
					$this->beforePost($model);
					$this->tracker->modify('changeserialnum', $id);
					$respond=$model->save();
					if( !$respond) 
						throw new CHttpException(404,'There is an error in master posting ');
					$this->afterPost($model);

					Yii::app()->session->remove('Changeserialnum');
					$this->redirect(array('view','id'=>$model->id));
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
            $this->tracker->delete('changeserialnum', $id);

            $detailmodels=Detailchangeserialnum::model()->findAll('id=:id',array(':id'=>$id));
            foreach($detailmodels as $dm) {
               $this->tracker->init();
               $this->tracker->delete('detailchangeserialnum', array('iddetail'=>$dm->iddetail));
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

               Yii::app()->session->remove('Changeserialnum');
               Yii::app()->session->remove('Detailchangeserialnum');
               Yii::app()->session->remove('Deletedetailchangeserialnum');
               $dataProvider=new CActiveDataProvider('Changeserialnum',
                  array(
                     'criteria'=>array(
                        'order'=>'idatetime desc'
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
               
                $model=new Changeserialnum('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Changeserialnum']))
			$model->attributes=$_GET['Changeserialnum'];

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
                $this->tracker->restore('changeserialnum', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Changeserialnum');
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
                $id = Yii::app()->tracker->createCommand()->select('id')->from('changeserialnum')
                	->where('idtrack = :p_idtrack', array(':p_idtrack'=>$idtrack))
                	->queryScalar();
                $this->tracker->restoreDeleted('detailchangeserialnum', "id", $id );
                $this->tracker->restoreDeleted('changeserialnum', "idtrack", $idtrack);
                
                
                $dataProvider=new CActiveDataProvider('Changeserialnum');
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
	 * @return Changeserialnum the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Changeserialnum::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Changeserialnum $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='changeserialnum-form')
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
             $model=new Changeserialnum;
             $model->attributes=Yii::app()->session['Changeserialnum'];

             $details=Yii::app()->session['Detailchangeserialnum'];
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

             $model=new Changeserialnum;
             $model->attributes=Yii::app()->session['Changeserialnum'];

             $details=Yii::app()->session['Detailchangeserialnum'];
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


             $model=new Changeserialnum;
             $model->attributes=Yii::app()->session['Changeserialnum'];

             $details=Yii::app()->session['Detailchangeserialnum'];
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
             $detailmodel=new Detailchangeserialnum;
             $detailmodel->attributes=$row;
             $respond=$detailmodel->insert();
             if (!$respond) {
                break;
             }
         }
         return $respond;
     }
     

     protected function saveDetails(array $details)
     {
         $idmaker=new idmaker();

         $respond=true;
         foreach ($details as $row) {
             $detailmodel=Detailchangeserialnum::model()->findByPk($row['iddetail']);
             if($detailmodel==NULL) {
                 $detailmodel=new Detailchangeserialnum;
             } else {
                 if(count(array_diff($detailmodel->attributes,$row))) {
                     $this->tracker->init();
                     $this->tracker->modify('detailchangeserialnum', array('iddetail'=>$detailmodel->iddetail));
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
             $detailmodel=Detailchangeserialnum::model()->findByPk($row['iddetail']);
             if($detailmodel) {
                 $this->tracker->init();
                 $this->trackActivity('d', $this->__DETAILFORMID);
                 $this->tracker->delete('detailchangeserialnum', $detailmodel->iddetail);
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
      $sql="select * from detailchangeserialnum where id='$id'";
      $details=Yii::app()->db->createCommand($sql)->queryAll();

      return $details;
     }


     protected function afterInsert(& $model)
     {
         $idmaker=new idmaker();
         $model->id=$idmaker->getCurrentID2();
         $model->idatetime=$idmaker->getDateTime();
         $model->regnum=$idmaker->getRegNum($this->formid);
         $model->userlog=Yii::app()->user->id;
         $model->datetimelog=$idmaker->getDateTime();
     }

     protected function afterPost(& $model)
     {
         $idmaker=new idmaker();
         if ($this->state == 'create') {
         	$idmaker->saveRegNum($this->formid, substr($model->regnum, 2));
         
        	$details = $this->loadDetails($model->id);
         	$this->processItems($model, $details);
         		         
	         /*if ($model->transname == 'AC16') {
	         	$data = Yii::app()->db->createCommand()
	         		->select()->from('requestdisplays')
	         		->where('regnum = :p_regnum', array(':p_regnum'=>$model->transid))
	         		->queryRow();
	         	$this->autoEntryDisplay($data['regnum'], $model->idwarehouse);
	         }*/
         } 
     }

     protected function beforePost(& $model)
     {
     	
         $idmaker=new idmaker();

         $model->userlog=Yii::app()->user->id;
         $model->datetimelog=$idmaker->getDateTime();
         if ($this->state == 'create')
         	$model->regnum='SK'.$idmaker->getRegNum($this->formid);
     }

     protected function beforeDelete(& $model)
     {	
     	$details = $this->loadDetails($model->id);
     	$this->unprocessItems($model, $details);
     	
     	/*if ($model->transname == 'AC16') {
     		$data = Yii::app()->db->createCommand()
     		->select()->from('requestdisplays')
     		->where('regnum = :p_regnum', array(':p_regnum'=>$model->transid))
     		->queryRow();
     		$this->removeEntryDisplay($data['regnum'], $model->idwarehouse);
     	}*/
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
     
     private function searchItem($model)
     {
     	$stockentries = Yii::app()->db->createCommand()
     		->select('iddetail, (\'detailstockentries\') as tablename')	
     		->from('detailstockentries')
     		->where('iditem = :p_iditem and serialnum = :p_serialnum',
     			array(':p_iditem'=>$model->iditem, ':p_serialnum'=>$model->oldserialnum))
     		->queryAll();
     	$stockexits = Yii::app()->db->createCommand()
     		->select('iddetail, (\'detailstockexits\') as tablename')
     		->from('detailstockexits')
     		->where('iditem = :p_iditem and serialnum = :p_serialnum',
     			array(':p_iditem'=>$model->iditem, ':p_serialnum'=>$model->oldserialnum))
     		->queryAll();
     	$deliveryreplaces = Yii::app()->db->createCommand()
     		->select('iddetail, (\'detaildeliveryreplaces\') as tablename')
     		->from('detaildeliveryreplaces')
     		->where('iditem = :p_iditem and serialnum = :p_serialnum',
     			array(':p_iditem'=>$model->iditem, ':p_serialnum'=>$model->oldserialnum))
     		->queryAll();
     	$retrievalreplaces = Yii::app()->db->createCommand()
	     	->select('id, (\'retrievalreplaces\') as tablename')
	     	->from('retrievalreplaces')
	     	->where('iditem = :p_iditem and serialnum = :p_serialnum',
	     			array(':p_iditem'=>$model->iditem, ':p_serialnum'=>$model->oldserialnum))
	     	->queryAll();
     	
     	$warehousesdata = array();
     	$warehouses = Yii::app()->db->createCommand()
     		->select('id')->from('warehouses')->queryColumn();
     	
     	foreach($warehouses as $wh) {
     		$data = Yii::app()->db->createCommand()
     			->select("iddetail, ('wh$wh') as tablename")
     			->from('wh'.$wh)
     			->where('iditem = :p_iditem and serialnum = :p_serialnum',
	     			array(':p_iditem'=>$model->iditem, ':p_serialnum'=>$model->oldserialnum))
	     		->queryAll();
     		$warehousesdata = array_merge($warehousesdata, $data);
     	}
     	$details = array();
     	if (count($stockentries)) {
     		foreach($stockentries as $detaildata) {
     			unset($temp);
     			$temp['id']	= $model->id;
     			$temp['iddetail'] = idmaker::getCurrentID2();
     			$temp['tablename'] = $detaildata['tablename'];
     			$temp['iddetailtable'] = $detaildata['iddetail'];
     			$details[] = $temp;
     		}
     	}
     	if (count($stockexits)) {
     		foreach($stockexits as $detaildata) {
     			unset($temp);
     			$temp['id']	= $model->id;
     			$temp['iddetail'] = idmaker::getCurrentID2();
     			$temp['tablename'] = $detaildata['tablename'];
     			$temp['iddetailtable'] = $detaildata['iddetail'];
     			$details[] = $temp;
     		}
     	}
     	if (count($deliveryreplaces)) {
     		foreach($deliveryreplaces as $detaildata) {
     			unset($temp);
     			$temp['id']	= $model->id;
     			$temp['iddetail'] = idmaker::getCurrentID2();
     			$temp['tablename'] = $detaildata['tablename'];
     			$temp['iddetailtable'] = $detaildata['iddetail'];
     			$details[] = $temp;
     		}
     	}
     	if (count($retrievalreplaces)) {
     		foreach($retrievalreplaces as $detaildata) {
     			unset($temp);
     			$temp['id']	= $model->id;
     			$temp['iddetail'] = idmaker::getCurrentID2();
     			$temp['tablename'] = $detaildata['tablename'];
     			$temp['iddetailtable'] = $detaildata['iddetail'];
     			$details[] = $temp;
     		}
     	}
     	if (count($warehousesdata)) {
     		foreach($warehousesdata as $detaildata) {
     			unset($temp);
     			$temp['id']	= $model->id;
     			$temp['iddetail'] = idmaker::getCurrentID2();
     			$temp['tablename'] = $detaildata['tablename'];
     			$temp['iddetailtable'] = $detaildata['iddetail'];
     			$details[] = $temp;
     		}
     	}
     	
     	return $details;
     }
     
     private function processItems($model, $details)
     {
     	foreach($details as $d) {
     		Yii::app()->db->createCommand()
     			->update($d['tablename'], array('serialnum'=>$model->newserialnum),
     				'iddetail = :p_iddetail', array(':p_iddetail'=>$d['iddetailtable']));	 	
    	}
     }
	
     private function unprocessItems($model, $details)
     {
     	foreach($details as $d) {
     		Yii::app()->db->createCommand()
     		->update($d['tablename'], array('serialnum'=>$model->oldserialnum),
     			'iddetail = :p_iddetail', array(':p_iddetail'=>$d['iddetailtable']));
     	}
     }
}