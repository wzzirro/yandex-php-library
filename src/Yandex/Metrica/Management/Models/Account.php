<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Account extends Model
{

    protected $userLogin = null;

    protected $createdAt = null;

    protected $mappingClasses = array(
        
    );

    protected $propNameMap = array(
        'userLogin' => 'user_login',
        'createdAt' => 'created_at'
    );

    /**
     * Retrieve the userLogin property
     *
     * @return string|null
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * Set the userLogin property
     *
     * @param string $userLogin
     * @return $this
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;
        return $this;
    }

    /**
     * Retrieve the createdAt property
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the createdAt property
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
