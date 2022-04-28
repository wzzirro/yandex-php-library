<?php

namespace Yandex\Market\Models;

use Yandex\Market\Models\Items;
use Yandex\Market\Models\Delivery;
use Yandex\Common\Model;

class CartRequest extends Model
{

    protected $currency = null;

    protected $items = null;

    protected $delivery = null;

    protected $mappingClasses = array(
        'items' => 'Yandex\Market\Models\Items',
        'delivery' => 'Yandex\Market\Models\Delivery'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the currency property
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the currency property
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Retrieve the items property
     *
     * @return Items|null
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the items property
     *
     * @param Items $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Retrieve the delivery property
     *
     * @return Delivery|null
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set the delivery property
     *
     * @param Delivery $delivery
     * @return $this
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
        return $this;
    }
}
