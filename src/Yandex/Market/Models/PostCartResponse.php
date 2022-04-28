<?php

namespace Yandex\Market\Models;

use Yandex\Market\Models\CartResponse;
use Yandex\Common\Model;

class PostCartResponse extends Model
{

    protected $cart = null;

    protected $mappingClasses = array(
        'cart' => 'Yandex\Market\Models\CartResponse'
    );

    protected $propNameMap = array(
        
    );

    /**
     * Retrieve the cart property
     *
     * @return CartResponse|null
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set the cart property
     *
     * @param CartResponse $cart
     * @return $this
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }
}
