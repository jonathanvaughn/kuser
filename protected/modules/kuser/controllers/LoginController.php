<?php

class LoginController extends Controller
{
    public $defaultAction = 'login';
    
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest)
        {
            $model=new KUserLogin;
        
/*        
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
*/        
            // collect user input data
            if(isset($_POST['KUserLogin']))
            {
                $model->attributes=$_POST['KUserLogin'];
                // validate user input and redirect to the previous page if valid
                if($model->validate())
                {
                    $this->visitNow();
                    if (strpos(Yii::app()->user->returnUrl, '/index.php') !== false)
                            $this->redirect(Yii::app()->controller->module->returnUrl);
                    else
                        $this->redirect(Yii::app()->user->returnUrl);
                }
            }
        
            // Kerberos authentication
            if ((extension_loaded('krb5')) && 
                    (Yii::app()->controller->module->kerberosKeytab != ''))
            {
                if (!empty($_SERVER['HTTP_AUTHORIZATION']))
                {
                    list($mech, $data) = split(' ', $_SERVER['HTTP_AUTHORIZATION']);

                    if (strtolower($mech) == 'negotiate')
                    {
                        // Check if this is actually Kerberos
                        if (substr($data,0,3) == 'YII')
                        {
                            // We have Kerberos data, attempt to authenticate using it
                            
                            $model->username = 'Kerberos:'.$data;
                            $model->password = Yii::app()->controller->module->kerberosKeytab;
                            //$model->rememberMe = $_POST[''];
                            if($model->validate())
                            {
                                $this->visitNow();
                                if (strpos(Yii::app()->user->returnUrl, 
                                        '/index.php') !== false)
                                    $this->redirect(Yii::app()->controller->module->returnUrl);
                                else
                                    $this->redirect(Yii::app()->user->returnUrl);
                            }
                        }
                        else
                        {
                            // Not Kerberos, some other kind of mechanism
                            /*$gss_mech = base64_decode($data);
                            if ((substr($gss_mech,0,4)) == 'NTLM')
                            {
                                // NTLM response - unsupported
                            }   
                            else
                            {
                                // Unknown - unsupported
                            }*/
                        }
                    }
                }
                else
                {
                    // No Kerberos data, we could support basic here...
                }
            }
                
            // display the login form
            $this->render('/kuser/login',array('model'=>$model));
        }
        else
        {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
    }
        
    private function visitNow()
    {
        $lastVisit = KUser::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }
}