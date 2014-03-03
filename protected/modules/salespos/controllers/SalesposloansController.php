<?php

class SalesposloansController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
      public $layout='//layouts/column2';
      public $formid='AB11';
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
            $this->trackActivity('v');
            $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
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

            $model=new Salesposloans;
            $this->afterInsert($model);

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['Salesposloans'])) {
               $model->attributes=$_POST['Salesposloans'];
               $this->beforePost($model);
               if($model->save()) {
                  $this->afterPost($model);
                  $this->redirect(array('view','id'=>$model->id));                 
               }    
            }

            $this->render('create',array('model'=>$model) );
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

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['Salesposloans'])) {
               $model->attributes=$_POST['Salesposloans'];

               $this->beforePost($model);   
               $this->tracker->modify('salesposloans', $id);
               if($model->save()) {
                  $this->afterPost($model);
                  $this->redirect(array('view','id'=>$model->id));
               }        
            }

            $this->render('update',array( 'model'=>$model ));
         } else {
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
            
            $this->tracker->delete('salesposloans', $id);

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

            $dataProvider=new CActiveDataProvider('Salesposloans',
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

            $model=new Salesposloans('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Salesposloans']))
               $model->attributes=$_GET['Salesposloans'];

            $this->render('admin',array('model'=>$model));
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
                'model'=>$model
             ));
         } else {
             throw new CHttpException(404,'You have no authorization for this operation.');
         }   
      }
        
      public function actionDeleted()
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
            Yii::app()->user->id)) {
             $this->render('deleted', array());
         } else {
            throw new CHttpException(404,'You have no authorization for this operation.');
         }   
      }
        
      public function actionRestore($idtrack)
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
            Yii::app()->user->id)) {
            $this->trackActivity('r');
            $this->tracker->restore('salesposloans', $idtrack);

            $dataProvider=new CActiveDataProvider('Salesposloans');
            $this->render('index',array('dataProvider'=>$dataProvider));
         } else {
            throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }
        
      public function actionRestoreDeleted($idtrack)
      {
         if(Yii::app()->authManager->checkAccess($this->formid.'-Update', 
            Yii::app()->user->id)) {
            $this->trackActivity('n');
            $this->tracker->restoreDeleted('salesposloans', $idtrack);

            $dataProvider=new CActiveDataProvider('Salesposloans');
            $this->render('index',array('dataProvider'=>$dataProvider));
         } else {
            throw new CHttpException(404,'You have no authorization for this operation.');
         }
      }
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Salesposloans the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
         $model=Salesposloans::model()->findByPk($id);
         if($model===null)
               throw new CHttpException(404,'The requested page does not exist.');
         return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Salesposloans $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
         if(isset($_POST['ajax']) && $_POST['ajax']==='salesposloans-form')
         {
               echo CActiveForm::validate($model);
               Yii::app()->end();
         }
	}
        
      protected function afterInsert(& $model)
      {
         $idmaker=new idmaker();
         $model->id=$idmaker->getcurrentID2();  
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
}