<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Delegate;
use Yandex\Common\Model;

class AddDelegateResponse extends Model
{

    protected $delegate = null;

    protected $mappingClasses = array(
        'delegate' => 'Yandex\Metrica\Management\Models\Delegate'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the delegate property
     *
     * @return Delegate|null
     */
    public function getDelegate()
    {
        return $this->delegate;
    }

    /**
     * Set the delegate property
     *
     * @param Delegate $delegate
     * @return $this
     */
    public function setDelegate($delegate)
    {
        $this->delegate = $delegate;
        return $this;
    }
}
