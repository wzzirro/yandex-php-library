<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\ObjectModel;

class Goals extends ObjectModel
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
    public function add($goal)
    {
        if (is_array($goal)) {
            $this->collection[] = new Goal($goal);
        } elseif (is_object($goal) && $goal instanceof Goal) {
            $this->collection[] = $goal;
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
