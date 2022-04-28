<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Delegates;
use Yandex\Common\Model;

class UpdateDelegateResponse extends Model
{

    protected $delegates = null;

    protected $mappingClasses = array(
        'delegates' => 'Yandex\Metrica\Management\Models\Delegates'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the delegates property
     *
     * @return Delegates|null
     */
    public function getDelegates()
    {
        return $this->delegates;
    }

    /**
     * Set the delegates property
     *
     * @param Delegates $delegates
     * @return $this
     */
    public function setDelegates($delegates)
    {
        $this->delegates = $delegates;
        return $this;
    }
}
