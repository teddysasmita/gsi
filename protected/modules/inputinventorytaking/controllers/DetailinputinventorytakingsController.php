<?php 

class DetailinputinventorytakingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $formid='AC8a';
	public $tracker;
	public $state;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
                  //'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($iddetail)
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-List',
				Yii::app()->user->id))  {
            $this->trackActivity('v');
            $model=$this->loadModel($iddetail);
            if(($model==NULL)&&isset(Yii::app()->session['Detailinputinventorytakings'])) {
                $model=new Detailinputinventorytakings;
                $model->attributes=$this->loadSession($iddetail);
            }  
            $this->render('view',array(
                    'model'=>$model,
            ));
		} else {
        	throw new CHttpException(404,'You have no authorization for this operation.');
        };
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-Append', 
                    Yii::app()->user->id))  {            
                $this->state='c';
                $this->trackActivity('c');

                $model=new Detailinputinventorytakings;
                $this->afterInsert($id, $model);

                $master=Yii::app()->session['master'];

                // Uncomment the following line if AJAX validation is needed
                $this->performAjaxValidation($model);

                if(isset($_POST['Detailinputinventorytakings'])) {
                    $temp=Yii::app()->session['Detailinputinventorytakings'];
                    $model->attributes=$_POST['Detailinputinventorytakings'];
                    //posting into session
                    $temp[]=$_POST['Detailinputinventorytakings'];
                    
                    if ($model->validate()) {
                        Yii::app()->session['Detailinputinventorytakings']=$temp;
                        if ($master=='create')
                            $this->redirect(array('default/createdetail'));
                        else if($master=='update')
                            $this->redirect(array('default/updatedetail'));
                    }    
                }
                $this->render('create',array(
                    'model'=>$model,'master'=>$master
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
	public function actionUpdate($iddetail)
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
                    Yii::app()->user->id))  {
                
                $this->state='u';
                $this->trackActivity('u');
                
                $master=Yii::app()->session['master'];
                
                $model=$this->loadModel($iddetail);
                if(isset(Yii::app()->session['Detailinputinventorytakings'])) {
                   //die("here");
                    $model=new Detailinputinventorytakings;
                    $model->attributes=$this->loadSession($iddetail);
                }
                $this->afterEdit($model);
                // Uncomment the following line if AJAX validation is needed
               $this->performAjaxValidation($model);

               if(isset($_POST['Detailinputinventorytakings']))
               {
                    $temp=Yii::app()->session['Detailinputinventorytakings'];
                    $model->attributes=$_POST['Detailinputinventorytakings'];
                    foreach ($temp as $tk=>$tv) {
                        if($tv['iddetail']==$_POST['Detailinputinventorytakings']['iddetail']) {
                            $temp[$tk]=$_POST['Detailinputinventorytakings'];
                            break;
                        }
                    }
                    //posting into session
		    if($model->validate()) {
                    	Yii::app()->session['Detailinputinventorytakings']=$temp;
			
                    	if ($master=='create')
                        	$this->redirect(array('default/createdetail'));
                    	else if($master=='update')
                        	$this->redirect(array('default/updatedetail'));
		    }	
                }

		$this->render('update',array(
			'model'=>$model,'master'=>$master
		));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($iddetail)
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-Delete', 
                    Yii::app()->user->id))  {
                $this->trackActivity('d');

                $details=Yii::app()->session['Detailinputinventorytakings'];
                foreach ($details as $ik => $iv) {
                   if($iv['iddetail']==$iddetail) {
                      if(isset(Yii::app()->session['Deletedetailinputinventorytakings']))
                         $deletelist=Yii::app()->session['Deletedetailinputinventorytakings'];
                      $deletelist[]=$iv;
                      Yii::app()->session['Deletedetailinputinventorytakings']=$deletelist;
                      unset($details[$ik]);
                      break;
                   }
                }
                Yii::app()->session['Detailinputinventorytakings']=$details;
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax'])) 
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('default/deleteDetail  ', 
                       'id'=>$iv['id']));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
                
        }
        
        public function actionDelete2($iddetail)
        {
        	if(Yii::app()->authManager->checkAccess($this->formid.'-Delete',
        			Yii::app()->user->id))  {
        		$this->trackActivity('d');
        
        		$model=$this->loadModel($iddetail);
        		$model->delete();
        		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        		if(!isset($_GET['ajax']))
        			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('default/deleteDetail  ',
        					'id'=>$iv['id']));
        	} else {
        		throw new CHttpException(404,'You have no authorization for this operation.');
        	}
        
        }
             

	/**
	 * Lists all models.
	 */
        /*
	public function actionIndex()
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-List', 
                Yii::app()->user->id)) {
                $this->trackActivity('l');
                
		$dataProvider=new CActiveDataProvider('Detailinputinventorytakings');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
	}
        */
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            if(Yii::app()->authManager->checkAccess($this->formid.'-List', 
                Yii::app()->user->id)) {
                $this->trackActivity('s');
                
		$model=new Detailinputinventorytakings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Detailinputinventorytakings']))
			$model->attributes=$_GET['Detailinputinventorytakings'];

		$this->render('admin',array(
			'model'=>$model,
		));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
	}
        
        public function actionHistory($iddetail)
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $model=$this->loadModel($iddetail);
                $this->render('history', array(
                   'model'=>$model,
                    
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }   
        }
        
        public function actionDeleted($id)
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $this->render('deleted', array(
                   'id'=>$id,
                    
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
                $this->tracker->restoreDeleted('detailinputinventorytakings', $idtrack);
                $dataProvider=new CActiveDataProvider('Detailinputinventorytakings');
                $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                ));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            } 
        }
        
        public function actionRestore($idtrack, $iddetail)
        {
            if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
               Yii::app()->user->id)) {
                $this->trackActivity('r');
                $this->tracker->restore('detailinputinventorytakings', $idtrack, 'iddetail');
                $model=$this->loadModel($iddetail);
                if(($model==NULL)&&isset(Yii::app()->session['Detailinputinventorytakings'])) {
                	$model=new Detailinputinventorytakings;
                	//$model->attributes=$this->loadSession($iddetail);
            	}  
            	$this->render('view',array(
                    'model'=>$model,
            	));
            } else {
                throw new CHttpException(404,'You have no authorization for this operation.');
            }
        }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Detailinputinventorytakings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Detailinputinventorytakings::model()->findByPk($id);
		/*
             if($model===null)
               throw new CHttpException(404,'The requested page does not exist.');
		*/
            return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Detailinputinventorytakings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='detailinputinventorytakings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        protected function loadSession($iddetail)
        {
            $details=Yii::app()->session['Detailinputinventorytakings'];
            foreach ($details as $row) {
                if($row['iddetail']==$iddetail)
                    return $row;
            }
            throw new CHttpException(404,'The requested page does not exist.');
        }
      
        protected function afterInsert($id, & $model)
        {
            $idmaker=new idmaker();
            $model->id=$id;  
            $model->iddetail=$idmaker->getCurrentID2();
	            $model->userlog=Yii::app()->user->id;
            $model->datetimelog=$idmaker->getDateTime();
        }
        
        protected function afterPost(& $model)
        {
            
        }
        
        protected function beforePost(& $model)
        {
            $idmaker=new idmaker();
            $model->userlog=Yii::app()->user->id;
            $model->datetimelog=$idmaker->getDateTime();
        }
        
        protected function beforeDelete(& $model)
        {
            
        }
        
        protected function afterDelete(& $model)
        {
               
        }
        
        protected function afterEdit(& $model)
        {
            
        }
        
        protected function trackActivity($action)
        {
            $this->tracker=new Tracker();
            $this->tracker->init();
            $this->tracker->logActivity($this->formid, $action);
        }
        
	public function actionUpdate2($iddetail)
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-Update',
				Yii::app()->user->id))  {
		
			$this->state='u';
			$this->trackActivity('u');
		
			$master=Yii::app()->session['master'];
		
			$model=$this->loadModel($iddetail);
			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);
		
			if(isset($_POST['Detailinputinventorytakings']))
			{
				$model->attributes=$_POST['Detailinputinventorytakings'];
				//posting into session
				if($model->validate()) {
					$model->save();

					$this->redirect(array('default/viewuser'));
				}
			}
		
			$this->render('update2',array(
					'model'=>$model,'master'=>$master
			));
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		}
		
		
	}
}
