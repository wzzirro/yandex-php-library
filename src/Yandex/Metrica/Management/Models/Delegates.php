<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\ObjectModel;

class Delegates extends ObjectModel
{

    protected $collection = array(
        
    );

    protected $mappingClasses = array(
        
    );

    protected $propNameMap = array(
        
    );

    /**
     * Add item
     */
    public function add($delegate)
    {
        if (is_array($delegate)) {
            $this->collection[] = new Delegate($delegate);
        } elseif (is_object($delegate) && $delegate instanceof Delegate) {
            $this->collection[] = $delegate;
        }

        return $this;
    }

    /**
     * Get items
     */
    public function getAll()
    {
        return $this->collection;
    }
}
