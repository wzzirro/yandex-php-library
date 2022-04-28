<?php

namespace Yandex\Market\Models;

use Yandex\Common\ObjectModel;

class Items extends ObjectModel
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
    public function add($item)
    {
        if (is_array($item)) {
            $this->collection[] = new Item($item);
        } elseif (is_object($item) && $item instanceof Item) {
            $this->collection[] = $item;
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
