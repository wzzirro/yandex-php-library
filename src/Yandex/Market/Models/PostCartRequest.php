<?php

namespace Yandex\Market\Models;

use Yandex\Market\Models\CartRequest;
use Yandex\Common\Model;

class PostCartRequest extends Model
{

    protected $cart = null;

    protected $mappingClasses = array(
        'cart' => 'Yandex\Market\Models\CartRequest'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the cart property
     *
     * @return CartRequest|null
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set the cart property
     *
     * @param CartRequest $cart
     * @return $this
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }
}
