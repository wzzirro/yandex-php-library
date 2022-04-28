<?php

namespace Yandex\Market\Models;

use Yandex\Market\Models\Pager;
use Yandex\Market\Models\Orders;
use Yandex\Common\Model;

class GetOrdersResponse extends Model
{

    protected $pager = null;

    protected $orders = null;

    protected $mappingClasses = array(
        'pager' => 'Yandex\Market\Models\Pager',
        'orders' => 'Yandex\Market\Models\Orders'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the pager property
     *
     * @return Pager|null
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * Set the pager property
     *
     * @param Pager $pager
     * @return $this
     */
    public function setPager($pager)
    {
        $this->pager = $pager;
        return $this;
    }

    /**
     * Retrieve the orders property
     *
     * @return Orders|null
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set the orders property
     *
     * @param Orders $orders
     * @return $this
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
        return $this;
    }
}
