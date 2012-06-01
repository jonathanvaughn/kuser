<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_principalName;
    
    const ERROR_KRB5_KEYTAB = 3; // Something went wrong loading the keytab
    const ERROR_KRB5_AUTH = 4; // Something went wrong while authenticating
    const ERROR_STATUS_INACTIVE = 5; // Account is inactive
    const ERROR_STATUS_MISSING = 6; // Succesful Krb Auth but account missing from DB
    const ERROR_STATUS_BAN = 7;

    /**
     * Authenticates a user
     * Check for Kerberos data, failing that attempt Kerberos based login with
     * the provided credentials from the form. (Form-based not yet implemented)
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
//        $this->errorCode=self::ERROR_NONE;
            
        // Check for WWW-Negotiate authentication, assuming we have the krb5
        // extension
        if ((substr($this->username,0,9) == 'Kerberos:') && (extension_loaded('krb5')))
        {
            // Extract the Negotiate data from the username field
            $_data = substr($this->username,9);
            // Check if this is Kerberos data
            if (substr($_data,0,3) == 'YII')
            {
                // We have Kerberos data, attempt to authenticate using it
                    
                $auth = new KRB5NegotiateAuth($this->password);
                    
                if (!$auth)
                {
                    // Problem with the Keytab
                    $this->errorCode = ERROR_KRB5_KEYTAB;
                }
                else 
                {
                    // Keytab succesfully loaded, try to authenticate
                    $reply = $auth->doAuthentication(base64_decode($this->username));
                        
                    if ($reply)
                    {
                            
                        // Successful authentication
                        $this->errorCode=self::ERROR_NONE;
                        $this->username = $auth->getAuthenticatedUser();
                        
                        $user = User::model()->notsafe()->findByAttributes(
                                array('username' => $this->username));
                        if ( $user === NULL )
                        {
                            $this->errorCode = self::ERROR_STATUS_MISSING;
                        }
                        else if ( $user->status == 0)
                        {
                            $this->errorCode = self::ERROR_STATUS_INACTIVE;
                        }
                        else
                        {
                            $this->_id = $user->id;
                            $this->_principalName = $this->username;
                            $this->errorCode = self::ERROR_NONE;
                        }
                    }
                    else
                    {
                        // Authentication failed
                        $this->errorCode = ERROR_KRB5_AUTH;
                    }
                }
            }
            if ($this->errorCode)
            {
                // If the user ends up seeing an error we don't want to fill
                // the form in with useless data
                $this->username = '';
                $this->password = '';
            }
        }
        else
        {
            // Normal login via form, but still authenticate via Kerberos
            // We aren't supporting this yet.
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        
            /*
            $users=array(
                // username => password
		'demo'=>'demo',
		'admin'=>'admin',
            );             
            if(!isset($users[$this->username]))
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            else if($users[$this->username]!==$this->password)
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else
            {
                $this->name = $this->username;
		$this->errorCode=self::ERROR_NONE;
            }*/
        }
        return $this->errorCode;
    }
        
    /**
     * Returns the unique identifier for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the unique identifier for the identity.
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Returns the display name for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the display name for the identity.
     */
    public function getName()
    {
        return $this->_principalName;
    }
}