<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    private $_forceLogin;
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $record = User::model()->findByAttributes(array('email' => $this->username));
        if ($record === null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if (!$this->getForceLogin() && $record->password !== md5($this->password)) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $record->user_id;
            $this->setState('fullname', $record->name);
            $this->setState('email', $record->email);
            $this->setState('photo_url', $record->photo_url);
            $this->setState('roles', ($record->role)?User::ADMIN_ROLE:User::GUEST_ROLE);
            $this->setState('is_oggetto', $record->is_oggetto);
            $this->setState('facebook_id', $record->facebook_id);
            $this->setState('github_id', $record->github_id);
            $this->setState('google_id', $record->google_id);
            $this->setState('linkedin_id', $record->linkedin_id);
            $this->setState('twitter_id', $record->twitter_id);
            $this->setState('vk_id', $record->vk_id);
            $this->setState('yandex_id', $record->yandex_id);

            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function setForceLogin($value)
    {
        $this->_forceLogin = $value;
        return $this;
    }

    public function getForceLogin()
    {
        return $this->_forceLogin;
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
}