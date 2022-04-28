<?php

namespace Yandex\Market\Models;

use Yandex\Market\Models\Order;
use Yandex\Common\Model;

class PostOrderAccept extends Model
{

    protected $order = null;

    protected $mappingClasses = array(
        'order' => 'Yandex\Market\Models\Order'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the order property
     *
     * @return Order|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the order property
     *
     * @param Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
}
