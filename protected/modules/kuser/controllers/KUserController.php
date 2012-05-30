<?php

class KUserController extends Controller
{
    /**
     * @var CActiveRecord the currently loaded data model instance. 
     */
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
     * specifies access control rules
     * this method used by 'accessControl' filter
     * @return array access control rules 
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', //allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array(
                'deny', //deny all users
                'users' => array('*'),
            ),
        );
    }
    
    /**
     * Display a particular model 
     */
    public function actionView()
    {
        $model = $this->loadModel();
        $this->render('view', array(
            'model' => $model,
            ));
    }
    
    /**
     * Lists all models 
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('KUser', array(
            'criteria' => array(
                'condition' => 'status>=' . KUser::STATUS_INACTIVE,
                ),
            'pagination' => array(
                'pageSize' => Yii::app()->controller->module->user_page_size,
            ),
        ));
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
    /**
     * Returns the data model based on primary key given in GET
     * If not found, HTTP exception raised 
     */
    public function loadModel()
    {
        if ($this->_model === NULL)
        {
            if (isset($_GET['id']))
                $this->_model = KUser::model()->findbyPk($_GET['id']);
            if ($this->_model === NULL)
                throw new CHttpException(404, 
                    KUserModule::t('The requested page does not exist.'));
        }
        return $this->_model;
    }
    
    /**
     * Returns the data model based on primary key given in GET
     * If not found, HTTP exception raised
     * @param integer the primary key value. Defaults to null, indicating to use _GET['id']
     */
    public function loadUser($id=NULL)
    {
        if ($this->_model === NULL)
        {
            if ($id!==NULL || isset($_GET['id']))
                $this->_model = KUser::model ()->findbyPk($id !== NULL ? 
                        $id : $_GET['id']);
            if ($this->_model === NULL)
                throw new CHttpException(404, 
                    KUserModule::t('The requested page does not exist.'));
        }
        return $this->_model;
    }
}