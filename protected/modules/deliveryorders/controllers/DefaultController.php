<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $formid='AC13';
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
                    
                $model=new Deliveryorders;
                $this->afterInsert($model);
                
                Yii::app()->session['master']='create';
                //as the operator enter for the first time, we load the default value to the session
                if (!isset(Yii::app()->session['Deliveryorders'])) {
                   Yii::app()->session['Deliveryorders']=$model->attributes;
                } else {
                // use the session to fill the model
                    $model->attributes=Yii::app()->session['Deliveryorders'];
                }
                
                // Uncomment the following line if AJAX validation is needed
                $this->performAjaxValidation($model);
               

                if (isset($_POST)){
                   if(isset($_POST['yt0'])) {
                      //The user pressed the button;
                      $model->attributes=$_POST['Deliveryorders'];
                      
                      $this->beforePost($model);
                      $respond=$model->save();
                      if($respond) {
                          $this->afterPost($model);
                      } else {
                          throw new CHttpException(404,'There is an error in master posting');
                      }
                      
                      if(isset(Yii::app()->session['Detaildeliveryorders']) ) {
                        $details=Yii::app()->session['Detaildeliveryorders'];
                        $respond=$respond&&$this->saveNewDetails($details);
                      } 
                      
                      if(isset(Yii::app()->session['Detaildeliveryorders2']) ) {
                        $details=Yii::app()->session['Detaildeliveryorders2'];
                        $respond=$respond&&$this->saveNewDetails2($details);
                      }
                      
                      if($respond) {
                         Yii::app()->session->remove('Deliveryorders');
                         Yii::app()->session->remove('Detaildeliveryorders');
                         $this->redirect(array('view','id'=>$model->id));
                      }

                   } else if (isset($_POST['command'])){
                      // save the current master data before going to the detail page
                      if($_POST['command']=='adddetail') {
                         $model->attributes=$_POST['Deliveryorders'];
                         Yii::app()->session['Deliveryorders']=$_POST['Deliveryorders'];
                         $this->redirect(array('detaildeliveryorders/create',
                            'id'=>$model->id, 'regnum'=>$model->regnum));
                      } else if($_POST['command']=='adddetail2') {
                         $model->attributes=$_POST['Deliveryorders'];
                         Yii::app()->session['Deliveryorders']=$_POST['Deliveryorders'];
                         $this->redirect(array('detaildeliveryorders2/create',
                            'id'=>$model->id, 'regnum'=>$model->regnum ));                          
                      } else if($_POST['command']=='loadInvoice') {
						$model->attributes=$_POST['Deliveryorders'];
						Yii::app()->session['Deliveryorders']=$_POST['Deliveryorders'];
						$this->loadInvoice($model->invnum, $model->id);
						$model->attributes=Yii::app()->session['Deliveryorders'];
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

             if(!isset(Yii::app()->session['Deliveryorders']))
                Yii::app()->session['Deliveryorders']=$model->attributes;
             else
                $model->attributes=Yii::app()->session['Deliveryorders'];

             if(!isset(Yii::app()->session['Detaildeliveryorders'])) 
               Yii::app()->session['Detaildeliveryorders']=$this->loadDetails($id);
             
             if(!isset(Yii::app()->session['Detaildeliveryorders2'])) 
               Yii::app()->session['Detaildeliveryorders2']=$this->loadDetails2($id);
             
            

             if(isset($_POST)) {
                 if(isset($_POST['yt0'])) {
                     $model->attributes=$_POST['Deliveryorders'];
                     // Uncomment the following line if AJAX validation is needed
                     $this->performAjaxValidation($model);
                     $this->beforePost($model);
                     $this->tracker->modify('deliveryorders', $id);
                     $respond=$model->save();
                     if($respond) {
                       $this->afterPost($model);
                     } else {
                       throw new CHttpException(404,'There is an error in master posting');
                     }

                     if(isset(Yii::app()->session['Detaildeliveryorders'])) {
                         $details=Yii::app()->session['Detaildeliveryorders'];
                         $respond=$respond&&$this->saveDetails($details);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail posting');
                         }
                     };
                     
                     if(isset(Yii::app()->session['Detaildeliveryorders2'])) {
                         $details=Yii::app()->session['Detaildeliveryorders2'];
                         $respond=$respond&&$this->saveDetails2($details);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail2 posting');
                         }
                     };

                     if(isset(Yii::app()->session['DeleteDetaildeliveryorders'])) {
                         $deletedetails=Yii::app()->session['DeleteDetaildeliveryorders'];
                         $respond=$respond&&$this->deleteDetails($deletedetails);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail deletion');
                         }
                     };
                     
                     if(isset(Yii::app()->session['DeleteDetaildeliveryorders2'])) {
                         $deletedetails=Yii::app()->session['DeleteDetaildeliveryorders2'];
                         $respond=$respond&&$this->deleteDetails2($deletedetails);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail2 deletion');
                         }
                     };

                     if($respond) {
                         Yii::app()->session->remove('Deliveryorders');
                         Yii::app()->session->remove('Detaildeliveryorders');
                         Yii::app()->session->remove('DeleteDetaildeliveryorders');
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
            $this->tracker->delete('deliveryorders', $id);

            $detailmodels=Detaildeliveryorders::model()->findAll('id=:id',array(':id'=>$id));
            foreach($detailmodels as $dm) {
               $this->tracker->init();
               $this->tracker->delete('detaildeliveryorders', array('iddetail'=>$dm->iddetail));
               $dm->delete();
            }

            $detailmodels=Detaildeliveryorders2::model()->findAll('id=:id',array(':id'=>$id));
            foreach($detailmodels as $dm) {
               $this->tracker->delete('detaildeliveryorders', array('iddetail'=>$dm->iddetail));
               $dm->delete();
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

               Yii::app()->session->remove('Deliveryorders');
               Yii::app()->session->remove('Detaildeliveryorders');
               Yii::app()->session->remove('Detaildeliveryorders2');
               Yii::app()->session->remove('DeleteDetaildeliveryorders');
               Yii::app()->session->remove('DeleteDetaildeliveryorders2');
               $dataProvider=new CActiveDataProvider('Deliveryorders',
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
               
                $model=new Deliveryorders('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Deliveryorders']))
			$model->attributes=$_GET['Deliveryorders'];

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
                $this->tracker->restore('deliveryorders', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Deliveryorders');
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
                $this->tracker->restoreDeleted('deliveryorders', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Deliveryorders');
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
	 * @return Deliveryorders the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Deliveryorders::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Deliveryorders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='deliveryorders-form')
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
             $model=new Deliveryorders;
             $model->attributes=Yii::app()->session['Deliveryorders'];

             $details=Yii::app()->session['Detaildeliveryorders'];
             $this->afterInsertDetail($model, $details);

             $this->render('create',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         } 
      }
      
      public function actionCreateDetail2()
      {
      //this action continues the process from the detail page
         if(Yii::app()->authManager->checkAccess($this->formid.'-Append', 
                 Yii::app()->user->id))  {
             $model=new Deliveryorders;
             $model->attributes=Yii::app()->session['Deliveryorders'];

             $details=Yii::app()->session['Detaildeliveryorders2'];
             $this->afterInsertDetail2($model, $details);

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

             $model=new Deliveryorders;
             $model->attributes=Yii::app()->session['Deliveryorders'];

             $details=Yii::app()->session['Detaildeliveryorders'];
             $this->afterUpdateDetail($model, $details);

             $this->render('update',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }
      
      public function actionUpdateDetail2()
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
                 Yii::app()->user->id))  {

             $model=new Deliveryorders;
             $model->attributes=Yii::app()->session['Deliveryorders'];

             $details=Yii::app()->session['Detaildeliveryorders2'];
             $this->afterUpdateDetail2($model, $details);

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


             $model=new Deliveryorders;
             $model->attributes=Yii::app()->session['Deliveryorders'];

             $details=Yii::app()->session['Detaildeliveryorders'];
             $this->afterDeleteDetail($model, $details);

             $this->render('update',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }
      
      public function actionDeleteDetail2()
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
                 Yii::app()->user->id))  {


             $model=new Deliveryorders;
             $model->attributes=Yii::app()->session['Deliveryorders'];

             $details=Yii::app()->session['Detaildeliveryorders2'];
             $this->afterDeleteDetail($model, $details);

             $this->render('update',array(
                 'model'=>$model,
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }

     protected function saveNewDetails(array $details)
     {                  
         foreach ($details as $row) {
             $detailmodel=new Detaildeliveryorders;
             $detailmodel->attributes=$row;
             $respond=$detailmodel->insert();
             if (!$respond) {
                break;
             }
         }
         return $respond;
     }
     
     protected function saveNewDetails2(array $details)
     {                  
         foreach ($details as $row) {
             $detailmodel=new Detaildeliveryorders2;
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
                $detailmodel=Detaildeliveryorders::model()->findByPk($row['iddetail']);
                if($detailmodel==NULL) {
                    $detailmodel=new Detaildeliveryorders;
                } else {
                    if(count(array_diff($detailmodel->attributes,$row))) {
                        $this->tracker->init();
                        $this->tracker->modify('detaildeliveryorders', array('iddetail'=>$detailmodel->iddetail));
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
        
        protected function saveDetails2(array $details)
        {
            $idmaker=new idmaker();
                        
            $respond=true;
            foreach ($details as $row) {
                $detailmodel=Detaildeliveryorders2::model()->findByPk($row['iddetail']);
                if($detailmodel==NULL) {
                  die("cannot find data");  
                  //$detailmodel=new Detaildeliveryorders2;
                } else {
                    if(count(array_diff($detailmodel->attributes,$row))) {
                        $this->tracker->init();
                        $this->tracker->modify('detaildeliveryorders2', array('iddetail'=>$detailmodel->iddetail));
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
                $detailmodel=Detaildeliveryorders::model()->findByPk($row['iddetail']);
                if($detailmodel) {
                    $this->tracker->init();
                    $this->trackActivity('d', $this->__DETAILFORMID);
                    $this->tracker->delete('detaildeliveryorders', $detailmodel->id);
                    $respond=$detailmodel->delete();
                    if (!$respond) {
                      break;
                    }
                }
            }
            return $respond;
        }

        protected function deleteDetails2(array $details)
        {
            $respond=true;
            foreach ($details as $row) {
                $detailmodel=Detaildeliveryorders::model()->findByPk($row['iddetail']);
                if($detailmodel) {
                    $this->tracker->init();
                    $this->trackActivity('d', $this->__DETAILFORMID);
                    $this->tracker->delete('detaildeliveryorders2', $detailmodel->id);
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
         $sql="select * from detaildeliveryorders where id='$id'";
         $details=Yii::app()->db->createCommand($sql)->queryAll();

         return $details;
        }
        
        protected function loadDetails2($id)
        {
         $sql="select * from detaildeliveryorders2 where id='$id'";
         $details=Yii::app()->db->createCommand($sql)->queryAll();

         return $details;
        }
        
        
        protected function afterInsert(& $model)
        {
            $idmaker=new idmaker();
            $model->id=$idmaker->getCurrentID2();
            $model->idatetime=$idmaker->getDateTime();
            $model->regnum=$idmaker->getRegNum($this->formid);
            $lookup=new lookup();
            $model->status=$lookup->reverseOrderStatus('Belum Diproses');
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
        
        protected function afterInsertDetail(& $model, $details)
        {
            //$this->sumDetail($model, $details);
        }
        
        protected function afterInsertDetail2(& $model, $details)
        {
        }
        

        protected function afterUpdateDetail(& $model, $details)
        {
        	//$this->sumDetail($model, $details);
        }
        
        protected function afterUpdateDetail2(& $model, $details)
        {
        }
        
        protected function afterDeleteDetail(& $model, $details)
        {
        	$this->sumDetail($model, $details);
        }
        
        protected function afterDeleteDetail2(& $model, $details)
        {
        }
        
        protected function trackActivity($action)
        {
            $this->tracker=new Tracker();
            $this->tracker->init();
            $this->tracker->logActivity($this->formid, $action);
        }
        
        private function sumDetail(& $model, $details)
        {
        	$total=0;
        	$totaldisc=0;
        	foreach ($details as $row) {
        		$total=$total+(($row['price']+$row['cost1']+$row['cost2'])*$row['qty']);
        		$totaldisc=$totaldisc+$row['discount']*$row['qty'];
        	}
        	$model->attributes=Yii::app()->session['Deliveryorders'];
        	$model->total=$total;
        	$model->discount=$totaldisc;
        }
        
        private function loadInvoice($invnum, $id)
        {
        	$master=Yii::app()->db->createCommand()
        		->select()->from('salespos')->where('regnum = :p_regnum', 
        		array(':p_regnum'=>$invnum))->queryRow(); 
        	
        	$masterdata=Yii::app()->session['Deliveryorders'];
        	if ($master['idreceiver'] <> '') {
        		$receiver=Yii::app()->db->createCommand()
        			->select()->from('salesreceivers')
        			->where('id = :p_id', array(':p_id'=>$master['idreceiver']))
        			->queryRow();
        		if ($receiver !== FALSE) {
        			$masterdata['receivername']=$receiver['name'];
        			$masterdata['receiveraddress']=$receiver['address'];
        			$masterdata['receiverphone']=$receiver['phone'];
        		}
        	};
        	Yii::app()->session['Deliveryorders']=$masterdata;
        	$details=Yii::app()->db->createCommand()
        		->select('b.*')->from('salespos a')->join('detailsalespos b', 'b.id = a.id')
        		->where('a.regnum = :p_regnum',
				array(':p_regnum'=>$invnum))->queryAll();
        	$detailsdone=Yii::app()->db->createCommand()
        		->select('b.*')->from('deliveryorders a')->join('detaildeliveryorders b', 'b.id = a.id')
        		->where('a.regnum = :p_regnum',
        			array(':p_regnum'=>$invnum))->queryAll();
        	foreach($details as $detail ) {
        		$detaildata['id']=$id;
        		$detaildata['iddetail']=idmaker::getCurrentID();
        		$detaildata['iditem']=$detail['iditem'];
        		$detaildata['invqty']=$detail['qty'];
        		$detaildata['qty']=0;
        		$detaildata['leftqty']=$detail['qty'];
        		$detaildata['idwarehouse']='';
        		$detaildata['userlog']=Yii::app()->user->id;
				$detaildata['datetimelog']=idmaker::getDateTime();
        		foreach($detailsdone as $detaildone) {
        			if ($detaildone['iditem']=$detail['iditem']) {
        				$detaildata['leftqty']=$detaildata['leftqty']-$detaildone['qty'];		
        			}
        		}
        		$detailsdata[]=$detaildata;
        	} 
        	Yii::app()->session['Detaildeliveryorders'] = $detailsdata;
        }
}