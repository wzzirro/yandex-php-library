<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Filter;
use Yandex\Common\Model;

class UpdateFilterResponse extends Model
{

    protected $filter = null;

    protected $mappingClasses = array(
        'filter' => 'Yandex\Metrica\Management\Models\Filter'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the filter property
     *
     * @return Filter|null
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set the filter property
     *
     * @param Filter $filter
     * @return $this
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }
}
