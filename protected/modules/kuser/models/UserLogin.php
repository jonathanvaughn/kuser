<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

//	private $_identity;
        
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                    'rememberMe' => KUserModule::t('Remember me next time'),
                    'username' => KUserModule::t('Principal Name'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $identity=new UserIdentity($this->username,$this->password);
            
            $identity->authenticate();
            
            switch ($identity->errorCode)
            {
                case UserIdentity::ERROR_NONE:
                    $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                    Yii::app()->user->login($identity,$duration); break;
                case UserIdentity::ERROR_USERNAME_INVALID: 
                    $this->addError('password', 
                            'Incorrect username or password.'); break;
                case UserIdentity::ERROR_PASSWORD_INVALID: 
                    $this->addError('password', 
                            'Incorrect username or password.'); break;
                case UserIdentity::ERROR_KRB5_KEYTAB: 
                    $this->addError('password', 
                            'Kerberos authentication error.'); 
                    $this->username = ''; $this->password = ''; break;
                case UserIdentity::ERROR_KRB5_AUTH: 
                    $this->addError('password', 
                            'Kerberos authentication error.'); 
                    $this->username = ''; $this->password = ''; break;
            }
        }	
    }
        
        
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
/*	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username, 
                                $this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}*/
}
