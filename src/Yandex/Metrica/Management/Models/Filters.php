<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\ObjectModel;

class Filters extends ObjectModel
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
    public function add($filter)
    {
        if (is_array($filter)) {
            $this->collection[] = new Filter($filter);
        } elseif (is_object($filter) && $filter instanceof Filter) {
            $this->collection[] = $filter;
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
