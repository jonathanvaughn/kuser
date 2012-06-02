<?php


/**
 * Description of User
 *
 * 
 */
class User extends CActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * The following are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $email
     * @var integer $createtime
     * @var integer $lastvisit
     * @var integer $superuser
     * @var ingeger $status 
     */
    
    /**
     * Returns the static model of the specified AR class
     * @return CActiveRecord the static model class 
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * @return string the associated database table name 
     */
    public function tableName()
    {
        return Yii::app()->getModule('kuser')->tableUsers;
    }
    
    /**
     * @return array validation rules for model attributes
     */
    public function rules()
    {
        if (Yii::app()->getModule('kuser')->isAdmin())
            return array(
                array('username', 'length', 'max' => 128, 
                    'message' => KUserModule::t(
                    'Incorrect principal name (length exceeded 128 characters).')),
                array('email', 'email'),
                array('username', 'unique', 'message' => KUserModule::t(
                    'This user\'s principal name already exists.')),
                array('email', 'unique', 'message' => KUserModule::t(
                    'This user\'s email address already exists.')),
                array('status', 'in', 'range' => array(self::STATUS_INACTIVE, 
                    self::STATUS_ACTIVE)),
                array('superuser', 'in', 'range' => array(0,1)),
                array('username, email, createtime, superuser, status', 'required'),
                array('createtime, lastvisit, superuser, status', 'numerical', 
                    'integerOnly' => true),
                );
        else if (Yii::app()->user->id == $this->id)
            return array(
                array('email', 'email'),
                array('email', 'unique', 'message' => KuserModule::t(
                        'This user\'s email address already exists.')),
            );
        else
            return array();
    }
    
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),            
        );
        if (isset(Yii::app()->getModule('kuser')->relations)) 
            $relations = array_merge($relations, 
                    Yii::app()->getModule('kuser')->relations);
        return $relations;
    }

    /**
     * @return array customized attribute labels (name => label) 
     */
    public function attributeLabels()
    {
        return array(
            'username' => KUserModule::t('Principal Name'),
            'email' => KUserModule::t('E-mail'),
            'id' => KUserModule::t('Id'),
            'createtime' => KUserModule::t('Creation date'),
            'lastvisit' => KUserModule::t('Last visit'),
            'superuser' => KUserModule::t('Superuser'),
            'status' => KUserModule::t('Status'),
        );
    }
    
    /**
     *  
     */
    public function scopes()
    {
        return array(
            'active' => array('condition' => 'status='.self::STATUS_ACTIVE),
            'inactive' => array('condition' => 'status='.self::STATUS_INACTIVE),
            'superuser' => array('condition' => 'superuser=1'),
            'notsafe' => array('select' => 
                'id, username, email, createtime, lastvisit, superuser, status'),
        );
    }
    
    /**
     * 
     */
    public function defaultScope()
    {
        return array(
            'select' => 
            'id, username, email, createtime, lastvisit, superuser, status',
        );
    }
    
    /**
     * 
     */
   public static function itemAlias($type, $code=NULL)
   {
       $_items = array(
           'UserStatus' => array(
               self::STATUS_INACTIVE => KUserModule::t('Inactive'),
               self::STATUS_ACTIVE => KUserModule::t('Active'),
           ),
           'AdminStatus' => array(
               '0' => KUserModule::t('No'),
               '1' => KUserModule::t('Yes'),
           ),
       );
       if (isset($code))
           return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
       else
           return isset($_items[$type]) ? $_items[$type] : false;
   }
}

