<?php

class AdminController extends Controller
{
    public $defaultAction = 'admin';
    
    private $_model;
    
    /**
     * @return array action filters 
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
            'accessControl', // perform access control for CRUD operations
        ));
    }
    
    /**
     * Specifies the access control rules, used by 'accessControl' filter
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete'
                'actions' => array('admin', 'delete', 'create', 'update', 'view'),
                'users' => array('*'), //array(KUserModule::getAdmins()),
                ),
            array('deny', // deny all users
                'users' => array('*'),
                ),
        );
    }
    
    /**
     * Manages all models 
     */
    public function actionAdmin()
    {
        $dataProvider = new CActiveDataProvider('KUser', array(
            'pagination' => array(
                'pagesize' => Yii::app()->controller->module->user_page_size,
                ),
        ));
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
    /**
     * Displays a particular model
     */
    public function actionView()
    {
        $model = $this->loadModule();
        $this->render('/user/view', array(
            'model' => $model,
        ));
    }
    
    /**
     * Create a new model. If successful, redirect browser to the corresponding
     * view page. 
     */
    public function actionCreate()
    {
        $model = new KUser;
        
        if (isset($_POST['KUser']))
        {
            $model->attributes = $_POST['KUser'];
            $model->createtime = time();
            
            if ( $model->validate() )
            {
                if ( $model->save() )
                {
                    $this->redirect(array(
                        '/kuser/user/view', 'id' => $model->id
                    ));
                }
                
            }
        }
        
        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    /**
     * Update a model, redirect to view page on success.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();
        
        if ( isset($_POST['KUser']) )
        {
            $model->attributes = $_POST['KUser'];
            
            if ( $model->validate() )
            {
                $model->save();
                $this->redirect(array(
                    '/kuser/view', 'id' => $model->id
                ));
            }
        }
        
        $this->render('/admin/update', array(
            'model' => $model,
        ));
    }
    
    /**
     * Deletes a model, redirects to index on success 
     */
    public function actionDelete()
    {
        if ( Yii::app()->request->isPostRequest )
        {
            // only allow deletion via POST
            $model = $this->loadModel();
            $model->delete();
            
            // if AJAX don't redirect
            if ( !isset($_POST['ajax']) )
                $this->redirect(array('/kuser/admin'));
        }
        else
            throw new CHttpException(400, 
                    KUserModule::t('Invalid request. Don\'t do that.'));
    }
    
    /**
     * Returns the data model based on the primary key given in GET variable
     * Throws an exception on failure 
     */
    public function loadModel()
    {
        if ( $this->_model === NULL )
        {
            if ( isset($_GET['id']) )
                $this->_model = KUser::model()->notsafe()->findByPk($_GET['id']);
            if ( $this->_model === NULL )
                throw CHttpException(404, KUserModule::t(
                        'The requested page does not exist.'));
        }
        return $this->_model;
    }
}