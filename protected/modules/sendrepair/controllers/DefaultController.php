<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $formid='AC25';
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
		if (Yii::app ()->authManager->checkAccess ( $this->formid . '-Append', Yii::app ()->user->id )) {
			$this->state = 'create';
			$this->trackActivity ( 'c' );
			
			$model = new Sendrepairs ();
			$this->afterInsert ( $model );
			
			Yii::app ()->session ['master'] = 'create';
			// as the operator enter for the first time, we load the default value to the session
			if (! isset ( Yii::app ()->session ['Sendrepairs'] )) {
				Yii::app ()->session ['Sendrepairs'] = $model->attributes;
			} else {
				// use the session to fill the model
				$model->attributes = Yii::app ()->session ['Sendrepairs'];
			}
			
			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation ( $model );
			if (isset ( $_POST )) {
				if (isset ( $_POST ['yt0'] )) {
					// The user pressed the button;
					$details = $this->processSelectedItems($_POST['yw0_c3']);
					$allitems = $details;
					$model->attributes = $_POST ['Sendrepairs'];
					
					$this->beforePost ( $model );
					$respond = $model->save ();
					if (! $respond) 
						throw new CHttpException ( 404, 'There is an error in master posting ');
				
					if ($details) {
						$respond = $respond && $this->saveNewDetails ( $details );
					}
					if (! $respond)
						throw new CHttpException ( 404, 'There is an error in detail posting' );
					
					
					$this->afterPost ( $model );
					Yii::app ()->session->remove ( 'Sendrepairs' );
					Yii::app ()->session->remove ( 'Detailsendrepairs' );
					Yii::app ()->session->remove ( 'Detailsendrepairs_temp' );
					$this->redirect ( array(
						'view','id' => $model->id) );
				} else if (isset ( $_POST ['command'] )) {
					// save the current master data before going to the detail page
					if ($_POST ['command'] == 'adddetail') {
						$model->attributes = $_POST ['Sendrepairs'];
						Yii::app ()->session ['Sendrepairs'] = $_POST ['Sendrepairs'];
						$this->redirect ( array (
								'detailsendrepairs/create',
								'id' => $model->id 
						) );
					} else if ($_POST ['command'] == 'setDO') {
						$model->attributes = $_POST ['Sendrepairs'];
						Yii::app ()->session ['Sendrepairs'] = $_POST ['Sendrepairs'];
						$this->loadDO ( $model->donum, $model->id );
					}
				}
			} 
			
			if (isset(Yii::app()->session['Detailsendrepairs_temp']))
				$allitems = Yii::app()->session['Detailsendrepairs_temp'];
			else {
				$allitems = $this->InsertDamagedItems($model->id);
				Yii::app()->session['Detailsendrepairs_temp'] = $allitems;
			}
			$this->render ( 'create', array (
					'model'=>$model, 'allitems'=>$allitems 
			) );
		} else {
			throw new CHttpException ( 404, 'You have no authorization for this operation.' );
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

             if(!isset(Yii::app()->session['Sendrepairs']))
                Yii::app()->session['Sendrepairs']=$model->attributes;
             else
                $model->attributes=Yii::app()->session['Sendrepairs'];

             if(!isset(Yii::app()->session['Detailsendrepairs'])) 
               Yii::app()->session['Detailsendrepairs']=$this->loadDetails($id);
             
             if(!isset(Yii::app()->session['Detailsendrepairs2'])) {
             	Yii::app()->session['Detailsendrepairs2']=$this->loadDetails2($id);
             }
             if (count(Yii::app()->session['Detailsendrepairs2']) == 0) {
             	$this->loadSerialNums($model->regnum, $model->id);
             }
             	
             // Uncomment the following line if AJAX validation is needed
             $this->performAjaxValidation($model);

             if(isset($_POST)) {
                 if(isset($_POST['yt0'])) {
                     $model->attributes=$_POST['Sendrepairs'];
                     $this->beforePost($model);
                     $this->tracker->modify('sendrepair', $id);
                     $respond=$model->save();
                     if($respond) {
                       $this->afterPost($model);
                     } else {
                     	throw new CHttpException(404,'There is an error in master posting ');
                     }

                     if(isset(Yii::app()->session['Detailsendrepaisr'])) {
                         $details=Yii::app()->session['Detailsendrepairs'];
                         $respond=$respond&&$this->saveDetails($details);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail posting');
                         }
                     };
                     
                     if(isset(Yii::app()->session['Detailsendrepairs2'])) {
                     	$details=Yii::app()->session['Detailsendrepairs2'];
                     	$respond=$respond&&$this->saveDetails2($details);
                     	if(!$respond) {
                     		throw new CHttpException(404,'There is an error in detail posting');
                     	}
                     };
                     
                     if(isset(Yii::app()->session['Deletedetailsendrepairs'])) {
                         $deletedetails=Yii::app()->session['Deletedetailsendrepairs'];
                         $respond=$respond&&$this->deleteDetails($deletedetails);
                         if(!$respond) {
                           throw new CHttpException(404,'There is an error in detail deletion');
                         }
                     };
                     
                     if(isset(Yii::app()->session['Deletedetailsendrepairs2'])) {
                     	$deletedetails=Yii::app()->session['Deletedetailsendrepairs2'];
                     	$respond=$respond&&$this->deleteDetails2($deletedetails);
                     	if(!$respond) {
                     		throw new CHttpException(404,'There is an error in detail deletion');
                     	}
                     };
                    
                     if($respond) {
                         Yii::app()->session->remove('Sendrepairs');
                         Yii::app()->session->remove('Detailsendrepairs');
                         Yii::app()->session->remove('Deletedetailsendrepairs');
                         Yii::app()->session->remove('Detailsendrepairs2');
                         Yii::app()->session->remove('Deletedetailsendrepairs2');
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
            $this->tracker->delete('sendrepair', $id);

            $detailmodels=Detailsendrepairs::model()->findAll('id=:id',array(':id'=>$id));
            foreach($detailmodels as $dm) {
               $this->tracker->init();
               $this->tracker->delete('detailsendrepairs', array('iddetail'=>$dm->iddetail));
               $dm->delete();
            }
            
            $detailmodels=Detailsendrepairs2::model()->findAll('id=:id',array(':id'=>$id));
            foreach($detailmodels as $dm) {
            	$this->tracker->init();
            	$this->tracker->delete('detailsendrepairs2', array('iddetail'=>$dm->iddetail));
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

               Yii::app()->session->remove('Sendrepairs');
               Yii::app()->session->remove('Detailsendrepairs');
               Yii::app()->session->remove('DeleteDetailsendrepairs');
               Yii::app()->session->remove('Detailsendrepairs_temp');
               $dataProvider=new CActiveDataProvider('Sendrepairs',
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
               
			$model=new Sendrepairs('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['Sendrepairs']))
				$model->attributes=$_GET['Sendrepairs'];

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
                $this->tracker->restore('sendrepair', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Sendrepairs');
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
                $this->tracker->restoreDeleted('sendrepair', $idtrack);
                
                $dataProvider=new CActiveDataProvider('Sendrepairs');
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
	 * @return Sendrepairs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sendrepairs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sendrepairs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sendrepair-form')
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
             $model=new Sendrepairs;
             $model->attributes=Yii::app()->session['Sendrepairs'];

             $details=Yii::app()->session['Detailsendrepairs'];
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

             $model=new Sendrepairs;
             $model->attributes=Yii::app()->session['Sendrepairs'];

             $details=Yii::app()->session['Detailsendrepairs'];
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


             $model=new Sendrepairs;
             $model->attributes=Yii::app()->session['Sendrepairs'];

             $details=Yii::app()->session['Detailsendrepairs'];
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
             $detailmodel=new Detailsendrepairs;
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
     		$detailmodel=new Detailsendrepairs2;
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
             $detailmodel=Detailsendrepairs::model()->findByPk($row['iddetail']);
             if($detailmodel==NULL) {
                 $detailmodel=new Detailsendrepairs;
             } else {
                 if(count(array_diff($detailmodel->attributes,$row))) {
                     $this->tracker->init();
                     $this->tracker->modify('detailsendrepairs', array('iddetail'=>$detailmodel->iddetail));
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
     		$detailmodel=Detailsendrepairs2::model()->findByPk($row['iddetail']);
     		if($detailmodel==NULL) {
     			$detailmodel=new Detailsendrepairs2;
     		} else {
     			if(count(array_diff($detailmodel->attributes,$row))) {
     				$this->tracker->init();
     				$this->tracker->modify('detailsendrepairs2', array('iddetail'=>$detailmodel->iddetail));
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
             $detailmodel=Detailsendrepairs::model()->findByPk($row['iddetail']);
             if($detailmodel) {
                 $this->tracker->init();
                 $this->trackActivity('d');
                 $this->tracker->delete('detailsendrepairs', $detailmodel->id);
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
     		$detailmodel=Detailsendrepairs2::model()->findByPk($row['iddetail']);
     		if($detailmodel) {
     			$this->tracker->init();
     			$this->trackActivity('d');
     			$this->tracker->delete('detailsendrepairs2', $detailmodel->id);
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
		$sql="select * from detailsendrepairs where id='$id'";
		$details=Yii::app()->db->createCommand($sql)->queryAll();

		return $details;
     }
     
     protected function loadDetails2($id)
     {
     	$sql="select * from detailsendrepairs2 where id='$id'";
     	$details=Yii::app()->db->createCommand($sql)->queryAll();
     
     	return $details;
     }


     protected function afterInsert(& $model)
     {
         $idmaker=new idmaker();
         $model->id=$idmaker->getCurrentID2();
         $model->idatetime=$idmaker->getDateTime();
         $model->userlog=Yii::app()->user->id;
         $model->datetimelog=$idmaker->getDateTime();
     }

     protected function afterPost(& $model)
     {
         $idmaker=new idmaker();
         if ($this->state == 'create')
         	$idmaker->saveRegNum($this->formid, substr($model->regnum, 2)); 
         
         /*$this->setStatusPO($model->idpurchaseorder,
            Yii::app()->session['Detailsendrepairs']);
         */
     }

     protected function beforePost(& $model)
     {
         $idmaker=new idmaker();

         $model->userlog=Yii::app()->user->id;
         $model->datetimelog=$idmaker->getDateTime();
         if ($this->state == 'create')
			$model->regnum='KS'.$idmaker->getRegNum($this->formid);
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
     
      private function loadDO($donum, $id)
      {
        $details=array();

        $sql=<<<EOS
        select a.qty from detailpurchasesorders a
        join purchasesorders b on b.id = a.id
        where b.regnum = :p_regnum and a.iditem = :p_iditem
EOS;
        $mycommand=Yii::app()->db->createCommand($sql);
        
        $dataPO=Yii::app()->db->createCommand()
           ->select('count(*) as totalqty, b.iditem, a.idwarehouse, a.transid')
           ->from('detailstockentries b')
           ->join('stockentries a', 'a.id=b.id')
           ->where('a.donum = :donum and b.serialnum <> :serialnum', 
           		array(':donum'=>$donum, 'serialnum'=>'Belum Diterima') )
           ->group('b.iditem, a.idwarehouse')
           ->queryAll();
        Yii::app()->session->remove('Detailsendrepairs');
         foreach($dataPO as $row) {
			$detail['iddetail']=idmaker::getCurrentID2();
			$detail['id']=$id;
			$detail['iditem']=$row['iditem'];
			$detail['qty']=$row['totalqty'];
			$detail['idwarehouse']=$row['idwarehouse'];
			$detail['idpurchaseorder']=$row['transid'];
			$mycommand->bindParam(':p_regnum', $row['transid'], PDO::PARAM_STR);
			$mycommand->bindParam(':p_iditem', $row['iditem'], PDO::PARAM_STR);
			$orderqty=$mycommand->queryScalar();	
			$detail['leftqty']=$orderqty-$row['totalqty'];
			$detail['userlog']=Yii::app()->user->id;
			$detail['datetimelog']=idmaker::getDateTime();
			
			$details[]=$detail; 
        }
        Yii::app()->session['Detailsendrepairs']=$details;
      }

      private function loadSerialNums($regnum, $id) 
      {
		$stockexits = Yii::app()->db->createCommand()
			->select('b.serialnum, b.iditem, b.iddetail')
			->from('stockexits a')
			->join('detailstockexits b', 'b.id = a.id')
			->where('a.transid = :p_transid', array(":p_transid"=>$regnum))
			->queryAll();
		$details = array();
		foreach ($stockexits as $retur) {
			$detail['id'] = $id;
			$detail['iddetail'] = $retur['iddetail'];
			$detail['iditem'] = $retur['iditem'];
			$detail['serialnum'] = $retur['serialnum'];
			$detail['userlog'] = Yii::app()->user->id;
         	$detail['datetimelog']=idmaker::getDateTime();
			
         	$details[] = $detail;
		}	
      	Yii::app()->session['Detailsendrepairs2'] = $details;
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
      
      
      public function actionSummary($id)
      {
      	$this->trackActivity('v');
      	$this->render('summary',array(
      			'model'=>$this->loadModel($id),
      	));
      
      }
      
      public function actionPrintsummary($id)
      {
      	if(Yii::app()->authManager->checkAccess($this->formid.'-List',
      			Yii::app()->user->id))  {     
	      	$this->trackActivity('v');
	      	Yii::import("application.vendors.tcpdf.*");
	      	require_once('tcpdf.php');
	      	$this->render('printsummary',array(
	      			'model'=>$this->loadModel($id),
	      	));
      	} else	 {
        	throw new CHttpException(404,'You have no authorization for this operation.');
        };
      }
      
	
	public function actionPrintlpb($id)
	{
		if(Yii::app()->authManager->checkAccess($this->formid.'-Append',
				Yii::app()->user->id)) {
			$this->trackActivity('p');
			 
			$model=$this->loadModel($id);
			$detailmodel=$this->loadDetails($id);
			$detailmodel2=$this->loadDetails2($id);
			Yii::import('application.vendors.tcpdf.*');
			require_once ('tcpdf.php');
			Yii::import('application.modules.sendrepair.components.*');
			require_once('printretur.php');
			ob_clean();
	
			execute($model, $detailmodel, $detailmodel2);
		} else {
			throw new CHttpException(404,'You have no authorization for this operation.');
		}
	}
	
	private function InsertDamagedItems($id)
	{
		$allitems = array();
		$warehouses = Yii::app()->db->createCommand()->select('id')->from('warehouses')->queryColumn();	
		foreach($warehouses as $wh) {
			$items = Yii::app()->db->createCommand()->select("iditem, serialnum, ('$wh') as idwarehouse")->from('wh'.$wh)
				->where('avail = :p_avail and status = :p_status', 
					array(':p_avail'=>'1', ':p_status'=>'0'))
				->queryAll();
			$allitems = array_merge($allitems, $items);	
		}
		foreach($allitems as & $item) {
			$item['id'] = $id;
			$item['iddetail'] = idmaker::getCurrentID2();
			$item['selected'] = '0';
			$item['exit'] = '0';
			$item['userlog'] = Yii::app()->user->id;
			$item['datetimelog'] = idmaker::getDateTime();
		}
		return $allitems;
	}
      
	private function processSelectedItems(array $selectIDs)
	{
		$found = array();
		foreach($selectIDs as $id) {
			foreach(Yii::app()->session['Detailsendrepairs_temp'] as $temp) {
				if ($temp['iddetail'] == $id) {
					$found[] = $temp;
					break;	
				}
			} 
		}	
		return $found;
	}
	
}