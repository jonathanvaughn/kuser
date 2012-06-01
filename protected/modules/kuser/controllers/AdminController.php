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
                'users' => KUserModule::getAdmins(),
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
        $dataProvider = new CActiveDataProvider('User', array(
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
        $model = new User;
        $profile = new Profile;
        
        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            $model->createtime = time();
            $profile->attributes=$_POST['Profile'];
            $profile->user_id=0;
            if ( $model->validate()  && $profile->validate())
            {
                if ( $model->save() )
                {
                    $profile->user_id = $model->id;
                    $profile->save();
                }
                $this->redirect(array('/kuser/user/view', 'id' => $model->id));
            } else $profile->validate();
        }
        
        $this->render('create', array(
            'model' => $model,
            'profile' => $profile,
        ));
    }
    
    /**
     * Update a model, redirect to view page on success.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();
        $profile = $model->profile;
        
        if ( isset($_POST['User']) )
        {
            $model->attributes = $_POST['User'];
            $profile->attributes = $_POST['Profile'];
            
            if ( $model->validate() && $profile->validate())
            {
                $model->save();
                $profile->save();
                $this->redirect(array(
                    '/kuser/view', 'id' => $model->id
                ));
            }
        }
        
        $this->render('/admin/update', array(
            'model' => $model,
            'profile' => $profile,
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
            $profile = Profile::model()->findByPk($model->id);
            $profile->delete();
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
                $this->_model = User::model()->notsafe()->findByPk($_GET['id']);
            if ( $this->_model === NULL )
                throw CHttpException(404, KUserModule::t(
                        'The requested page does not exist.'));
        }
        return $this->_model;
    }
}