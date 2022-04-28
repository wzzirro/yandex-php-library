<?php

namespace Yandex\Market\Models;

use Yandex\Market\Models\Items;
use Yandex\Market\Models\DeliveryOptions;
use Yandex\Common\Model;

class CartResponse extends Model
{

    protected $items = null;

    protected $deliveryOptions = null;

    protected $paymentMethods = null;

    protected $mappingClasses = array(
        'items' => 'Yandex\Market\Models\Items',
        'deliveryOptions' => 'Yandex\Market\Models\DeliveryOptions'
    );

    protected $propNameMap = array(
        
    );

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
     * Retrieve the deliveryOptions property
     *
     * @return DeliveryOptions|null
     */
    public function getDeliveryOptions()
    {
        return $this->deliveryOptions;
    }

    /**
     * Set the deliveryOptions property
     *
     * @param DeliveryOptions $deliveryOptions
     * @return $this
     */
    public function setDeliveryOptions($deliveryOptions)
    {
        $this->deliveryOptions = $deliveryOptions;
        return $this;
    }

    /**
     * Retrieve the paymentMethods property
     *
     * @return array|null
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    /**
     * Set the paymentMethods property
     *
     * @param array $paymentMethods
     * @return $this
     */
    public function setPaymentMethods($paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
        return $this;
    }
}
