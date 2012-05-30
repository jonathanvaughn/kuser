<?php

class KLogoutController extends Controller
{
    public $defaultAction = 'logout';
    
    /**
     * Logout the current user 
     */
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}