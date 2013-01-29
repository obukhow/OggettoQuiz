<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $photo_url
 * @property integer $role
 * @property string $password
 * @property integer $is_oggetto
 * @property string $facebook_id
 * @property string $github_id
 * @property string $google_id
 * @property string $linkedin_id
 * @property string $twitter_id
 * @property string $vk_id
 * @property string $yandex_id
 */
class User extends CActiveRecord
{
    const ADMIN_ROLE = 'admin';
    const GUEST_ROLE = 'guest';

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Entity table name
     * 
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * Model validation rules
     * 
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('role, is_oggetto', 'numerical', 'integerOnly' => true),
            array('name, email, photo_url, password, facebook_id, github_id, google_id, linkedin_id, twitter_id, vk_id, yandex_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, name, email, photo_url, role, password, is_oggetto, facebook_id, github_id, google_id, linkedin_id, twitter_id, vk_id, yandex_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * User relations
     * 
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * Labels for User entity attributes
     * 
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id'     => 'User',
            'name'        => 'Name',
            'email'       => 'Email',
            'photo_url'   => 'Photo Url',
            'role'        => 'Role',
            'password'    => 'Password',
            'is_oggetto'  => 'Is Oggetto',
            'facebook_id' => 'Facebook',
            'github_id'   => 'Github',
            'google_id'   => 'Google',
            'linkedin_id' => 'Linkedin',
            'twitter_id'  => 'Twitter',
            'vk_id'       => 'Vk',
            'yandex_id'   => 'Yandex',
            );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * 
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('photo_url', $this->photo_url, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('is_oggetto', $this->is_oggetto);
        $criteria->compare('facebook_id', $this->facebook_id, true);
        $criteria->compare('github_id', $this->github_id, true);
        $criteria->compare('google_id', $this->google_id, true);
        $criteria->compare('linkedin_id', $this->linkedin_id, true);
        $criteria->compare('twitter_id', $this->twitter_id, true);
        $criteria->compare('vk_id', $this->vk_id, true);
        $criteria->compare('yandex_id', $this->yandex_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieve random password
     *
     * @param int $length password length
     * @return  string
     */
    public function generatePassword($length = 6)
    {
        return substr(md5(uniqid(rand(), true)), 0, $length);
    }

    /**
     * Check identity and create a new user if requested user cannot be found
     *
     * @param CBaseUserIdentity $identity identity
     *
     * @return User
     */
    public function createUserByIdentity(CBaseUserIdentity $identity)
    {
        
        if (!($user = $this->loadUserByIdentity($identity))) {
            $user = new self;
            $user->name       = $identity->getName();
            $user->email      = $identity->getState('email');
            $user->photo_url  = $identity->getState('photo');
            $user->password   = md5($this->generatePassword());
            $user->is_oggetto = false;
        }

        if ($serviceId = $identity->getState('service_id')) {
            $user->$serviceId = $identity->getId();
        }
        $user->save();
        return $user;
    }

    /**
     * Load User by User identity
     *
     * @param CBaseUserIdentity $identity user identity
     *
     * @return User|bool
     */
    public function loadUserByIdentity(CBaseUserIdentity $identity)
    {
        $user = false;
        if ($identity->getState('service_id')) {
            $user = self::model()->findByAttributes(array($identity->getState('service_id') => $identity->getId()));
        }
        if (!$user && $identity->getState('email')) {
            $user = self::model()->findByAttributes(array('email' => $identity->getState('email')));
        }
        return $user;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public static function getRoles()
    {
        return array(
            self::GUEST_ROLE,
            self::ADMIN_ROLE,
        );
    }

    /**
     * Get role
     *
     * @param int $role id
     * @return str
     */
    public static function getRole($role)
    {
        $array = self::getRoles();
        return isset($array[$role]) ?$array[$role] : '';
    }
}