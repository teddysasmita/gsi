<?php

class DefaultController extends Controller
{
      	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $formid='AC8';
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
                
                $model=new Inputinventorytakings;
                $this->afterInsert($model);
                 
                Yii::app()->session['master']='create';
                //as the operator enter for the first time, we load the default value to the session
                if (!isset(Yii::app()->session['Inputinventorytakings'])) {
                   Yii::app()->session['Inputinventorytakings']=$model->attributes;
                } else {
                // use the session to fill the model
                    $model->attributes=Yii::app()->session['Inputinventorytakings'];
                }

                // Uncomment the following line if AJAX validation is needed
                $this->performAjaxValidation($model);

                if (isset($_POST)){
                   if(isset($_POST['yt0']))
                   {
                      //The user pressed the button;
                      $model->attributes=$_POST['Inputinventorytakings'];
                      
                      if(isset(Yii::app()->session['Detailinputinventorytakings']))
                        $details=Yii::app()->session['Detailinputinventorytakings'];

                      $this->beforePost($model);
                      $respond=$model->save();
                      if($respond) {
                          $this->afterPost($model);
                      } else {
                          throw new CHttpException(404,'There is an error in master posting');
                      }
                      
                      if (isset($details)) {
                          $respond=$respond&&$this->saveNewDetails($model, $details);
                      }    
                      if($respond) {
                         Yii::app()->session->remove('Inputinventorytakings');
                         Yii::app()->session->remove('Detailinputinventorytakings');
                         $this->redirect(array('view','id'=>$model->id));
                      }

                   } else if (isset($_POST['command'])){
                      // save the current master data before going to the detail page
                      if($_POST['command']=='adddetail') {
                         $model->attributes=$_POST['Inputinventorytakings'];
                         Yii::app()->session['Inputinventorytakings']=$_POST['Inputinventorytakings'];
                         $this->redirect(array('detailinputinventorytakings/create','id'=>$model->id));
                      }
                   }
                }

                $this->render('create',array(
                    'model'=>$model,
                ));
            }  else {
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
                
                if(!isset(Yii::app()->session['Inputinventorytakings']))
                   Yii::app()->session['Inputinventorytakings']=$model->attributes;
                else
                   $model->attributes=Yii::app()->session['Inputinventorytakings'];
                
                if(!isset(Yii::app()->session['Detailinputinventorytakings'])) 
                    Yii::app()->session['Detailinputinventorytakings']=$this->loadDetails($id);
                    
                // Uncomment the following line if AJAX validation is needed
                $this->performAjaxValidation($model);

                if(isset($_POST)) {
                    if(isset($_POST['yt0'])) {
                        $model->attributes=$_POST['Inputinventorytakings'];
                        
                        $this->beforePost($model);
                        $this->tracker->modify('inputinventorytakings', $id);
                        $respond=$model->save();
                        if($respond) {
                          $this->afterPost($model);
                        } else {
                          throw new CHttpException(404,'There is an error in master posting');
                        }
                        
                        if(isset(Yii::app()->session['Detailinputinventorytakings']))
                            $details=Yii::app()->session['Detailinputinventorytakings'];
                        if(isset($details)) {
                            $respond=$respond&&$this->saveDetails($model, $details);
                            if($respond) {
                            
                            } else {
                              throw new CHttpException(404,'There is an error in detail posting');
                            }
                        };
                        
                        if(isset(Yii::app()->session['Deletedetailinputinventorytakings']))
                            $deletedetails=Yii::app()->session['Deletedetailinputinventorytakings'];
                        if(isset($deletedetails)) {
                            $respond=$respond&&$this->deleteDetails($model, $deletedetails);
                            if($respond) {
                            
                            } else {
                              throw new CHttpException(404,'There is an error in detail deletion');
                            }
                        };
                                                
                        if($respond) {
                            Yii::app()->session->remove('Inputinventorytakings');
                            Yii::app()->session->remove('Detailinputinventorytakings');
                            Yii::app()->session->remove('Deletedetailinputinventorytakings');
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
                $this->trackActivity('d');
                $model=$this->loadModel($id);
                $this->beforeDelete($model);
                $this->tracker->delete('inputinventorytakings', $id);
                
                $detailmodels=Detailinputinventorytakings::model()->findAll('id=:id',array(':id'=>$id));
                foreach($detailmodels as $dm) {
                   $this->tracker->init();
                    $this->tracker->delete('detailinputinventorytakings', array('iddetail'=>$dm->iddetail));
                    $dm->delete();
                    $this->afterDeleteDetail($model, $dm);
                }
                $model->delete();
                $this->afterDelete();
                
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
            Yii::app()->session->remove('Inputinventorytakings');
            Yii::app()->session->remove('Detailinputinventorytakings');
            Yii::app()->session->remove('Detailinputinventorytakings2');
            Yii::app()->session->remove('DeleteDetailinputinventorytakings');

            $dataProvider=new CActiveDataProvider('Inputinventorytakings',
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
                
        	$model=new Inputinventorytakings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inputinventorytakings']))
			$model->attributes=$_GET['Inputinventorytakings'];

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
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inputinventorytakings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inputinventorytakings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inputinventorytakings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inputinventorytakings-form')
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
                $model=new Inputinventorytakings;
                $model->attributes=Yii::app()->session['Inputinventorytakings'];

                $details=Yii::app()->session['Detailinputinventorytakings'];
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
            
                $model=new Inputinventorytakings;
                $model->attributes=Yii::app()->session['Inputinventorytakings'];

                $details=Yii::app()->session['Detailinputinventorytakings'];
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
            
                
                $model=new Inputinventorytakings;
                $model->attributes=Yii::app()->session['Inputinventorytakings'];

                $details=Yii::app()->session['Detailinputinventorytakings'];
                $this->afterDeleteDetail($model, $details);

                $this->render('update',array(
                    'model'=>$model,
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
                $this->tracker->restoreDeleted('inputinventorytakings', $idtrack);
                $this->tracker->restoreDeleted('detailinputinventorytakings', $idtrack);
                $dataProvider=new CActiveDataProvider('Inputinventorytakings');
                $this->render('index',array(
                    'dataProvider'=>$dataProvider,
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
                $this->tracker->restore('inputinventorytakings', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Inputinventorytakings');
                $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
        }
        
        protected function saveNewDetails($model, array $details)
        {                  
            foreach ($details as $row) {
                $detailmodel=new Detailinputinventorytakings;
                $detailmodel->attributes=$row;
                $respond=$detailmodel->insert();
                if (!$respond) {
                   break;
                } else {
                	$this->afterPostDetail($model, $detailmodel, 'insert');
                }
            }
            return $respond;
        }
      
        protected function saveDetails($model, array $details)
        {
            $idmaker=new idmaker();
            
            foreach ($details as $row) {
                $detailmodel=Detailinputinventorytakings::model()->findByPk($row['iddetail']);
                if($detailmodel==NULL) {
                    $detailmodel=new Detailinputinventorytakings;
                } else {
                    if(count(array_diff($detailmodel->attributes,$row))) {
                        $this->tracker->init();
                        $this->tracker->modify('detailinputinventorytakings', array('iddetail'=>$detailmodel->iddetail));
                    }    
                }
                $detailmodel->attributes=$row;
                $detailmodel->userlog=Yii::app()->user->id;
                $detailmodel->datetimelog=$idmaker->getDateTime();
                $respond=$detailmodel->save();
                if (!$respond) {
                  break;
                } else {
                	$this->afterPostDetail($model, $detailmodel, 'update');
                }
             }
             return $respond;
        }
      
        protected function deleteDetails($model, array $details)
        {
            $respond=true;
            foreach ($details as $row) {
                $detailmodel=Detailinputinventorytakings::model()->findByPk($row['iddetail']);
                if($detailmodel) {
                    $this->tracker->init();
                    $this->trackActivity('d', $this->detailformid);
                    $this->tracker->delete('detailinputinventorytakings', $detailmodel->id);
                    $respond=$detailmodel->delete();
                    if (!$respond) {
                      break;
                    } else {
                    	$this->afterDeleteDetail($model, $detailmodel);
                    }
                }
            }
            return $respond;
        }


        protected function loadDetails($id)
        {
            $sql="select * from detailinputinventorytakings where id='$id'";
            $details=Yii::app()->db->createCommand($sql)->queryAll();

            return $details;
        }

        protected function afterInsert(& $model)
        {
            $idmaker=new idmaker();
            $model->id=$idmaker->getCurrentID2();
            $model->idatetime=$idmaker->getDateTime();
            $model->regnum=$idmaker->getRegNum($this->formid);
        }

        protected function afterInsertDetail(& $model, $details)
        {
         
        }

        protected function afterUpdateDetail(& $model, $details)
        {
               
        }
        
        protected function afterDeleteDetail(& $model, $detail)
        {
        	$im=new InventoryManager();
        	$im->deleteEntry($detail->iddetail);
        }
      
        protected function afterPost(& $model)
        {
            $idmaker=new idmaker();
            $idmaker->saveRegNum($this->formid, $model->regnum);             
        }
        
        protected function beforePost(& $model)
        {
            $idmaker=new idmaker();
            
            $model->userlog=Yii::app()->user->id;
            $model->datetimelog=$idmaker->getDateTime();
            $model->regnum=$idmaker->getRegNum($this->formid);
        }
        
        protected function beforeDelete(& $model)
        {
            
        }
        
        protected function afterDelete()
        {
               
        }
        
        protected function afterEdit(& $model)
        {
            
        }
        
        protected function trackActivity($action, $formid=NULL)
        {
            $this->tracker=new Tracker();
            $this->tracker->init();
            if($formid)
                $this->tracker->logActivity($formid, $action);
            else
                $this->tracker->logActivity($this->formid, $action);
        }
        
        private function afterPostDetail(& $model, $detail, $mode)
        {
        	/*$im=new InventoryManager();
        	if ($mode=='update')
        		$im->updateEntry($detail->iddetail, $model->idatetime, 
        				$detail->iditem, $detail->idwarehouse, $detail->qty);
        	else if ($mode=='insert')
        		$im->addEntry($this->formid, $detail->iddetail, $model->idatetime, $detail->iditem, 
        			$detail->idwarehouse, $detail->qty);*/
        }
}
