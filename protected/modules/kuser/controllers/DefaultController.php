<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            $dataProvider = new CActiveDataProvider('KUser', array(
                'criteria' => array(
                    'condition' => 'status>='.KUser::STATUS_INACTIVE,
                ),
                'pagination' => array(
                    'pageSize' => Yii::app()->controller->module->user_page_size,
                ),
            ));
            
            $this->render('/user/index', array(
               'dataProvider' => $dataProvider, 
            ));
	}
}