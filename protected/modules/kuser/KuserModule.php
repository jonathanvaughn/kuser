<?php
/**
 * Yii-KUser module 
 * 
 * This module implements a Yii User style module for use with rights,
 * however it uses Kerberos for authentication and implements SPNEGO for SSO.
 * 
 * @author Jonathan Vaughn <jvaughn@creatuity.com>
 * @link https://github.com/jonathanvaughn/yii_spnego
 * @copyright Copyright (C) 2012 Jonathan Vaughn
 * @license Not sure yet ... Modified BSD? MIT?
 */



class KuserModule extends CWebModule
{
    /**
     * @var int
     * @desc number of users to display in a page 
     */
    public $user_page_size = 20;
    
    /**
     * @var int
     * @desc items on page
     */
    public $fields_page_size = 10;
    
    public $kerberosKeytab = '';
    
    /**
     * @var boolean
     * @desc Automatically attempt SSO login when user visits any page - not implemented yet
     */
    public $autoLogin = false;
    
    public $loginUrl = array('/kuser/login');
    public $logoutUrl = array('/kuser/logout');
    public $adminUrl = array('/kuser/admin');
    public $viewUrl = array('/kuser/view');
    public $profileUrl = array('/kuser/profile');
    public $returnUrl = array('/');
    public $returnLogoutUrl = array('/');
            
    public $fieldsMessage = '';
    
    public $relations = array();
    public $profileRelations = array();
    
    public $tableUsers = '{{users}}';
    public $tableProfiles = '{{profiles}}';
    public $tableProfileFields = '{{profiles_fields}}';
    
    static private $_user;
    static private $_admin;
    static private $_admins;

    public $componentBehaviors=array();
    
    public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'kuser.models.*',
			'kuser.components.*',
		));
	}

    public function getBehaviorsFor($componentName)
    {
        if (isset($this->componentBehaviors[$componentName]))
        {
            return $this->componentBehaviors[$componentName];
        }
        else
        {
            return array();
        }
    }
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

        
    /**
     * @param $str
     * @param $params
     * @param $dic
     * @return string 
     */
    public static function t($str='',$params=array(),$dic='KUser') 
    {
        return Yii::t('KuserModule.'.$dic, $str, $params);
    }
    
    /**
     * Return admin status
     * @return boolean
     */
    public static function isAdmin()
    {
        if (Yii::app()->user->isGuest)
            return false;
        else
        {
            if (!isset(self::$_admin)) 
            {
                if (self::user()->superuser)
                    self::$_admin = true;
                else
                    self::$_admin = false;
            }
            return self::$_admin;
        }
    }
    
    /**
     * Return admins
     * @return array superusers names 
     */
    public static function getAdmins() 
    {
        if (!self::$_admins)
        {
            $admins = User::model()->active()->superuser()->findAll();
            $return_name = array();
            foreach ($admins as $admin)
                array_push($return_name,$admin->username);
            self::$_admins = $return_name;
        }
        return self::$_admins;
    }
        
    /**
     * Return safe user data
     * @param user id not required 
     * @return user object or false 
     */    
    public static function user($id=0)
    {
        
        if ($id)
            return User::model()->activate()->findByPk($id);
        else
        {
            if (Yii::app()->user->isGuest)
            {
                return false;
            }
            else
            {
                if (!self::$_user)
                {
                    self::$_user = 
                            User::model()->active()->findByPk(Yii::app()->user->id);
                }
                return self::$_user;
            }
        }
    }
    
    /**
     * Return safe user data
     * @param user id not required
     * @return user object or false 
     */
    public function users()
    {
        return User;
    }

}
