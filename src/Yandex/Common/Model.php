<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Common;


abstract class Model
{

    protected $mappingClasses = array(

    );

    protected $propNameMap = array(

    );

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->fromArray($data);
    }

    /**
     * Set from array
     *
     * @param array $data
     * @return $this
     */
    public function fromArray($data)
    {
        foreach ($data as $key => $val) {

            if (is_int($key)) {
                if (method_exists($this, "add")) {
                    $this->add($val);
                }
            }

            $propertyName = $key;
            $ourPropertyName = array_search($propertyName, $this->propNameMap);

            if ($ourPropertyName) {
                $propertyName = $ourPropertyName;
            }

            if (!empty($this->propNameMap)) {
                if (array_key_exists($key, $this->propNameMap)) {
                    $propertyName = $this->propNameMap[$key];
                }
            }

            if (property_exists($this, $propertyName)) {
                if (isset($this->mappingClasses[$propertyName])) {
                    $this->{$propertyName} = new $this->mappingClasses[$propertyName]($val);
                } else {
                    $this->{$propertyName} = $val;
                }
            }
        }
        return $this;
    }

    /**
     * Set from json
     *
     * @param string $json
     * @return $this
     */
    public function fromJson($json)
    {
        $this->fromArray(json_decode($json, true));
        return $this;
    }

    /**
     * Get array from object
     *
     * @return array
     */
    public function toArray()
    {
        return $this->toArrayRecursive($this);
    }

    /**
     * Get array from object
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArrayRecursive($this));
    }

    /**
     * Get array from object
     *
     * @param array|object $data
     * @return array
     */
    protected function toArrayRecursive($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                if ($key === "mappingClasses" || $key === "propNameMap") {
                    continue;
                }

                $propNameMap = $key;

                if (!empty($this->propNameMap)
                    && array_key_exists($key, $this->propNameMap)
                ) {
                    $propNameMap = $this->propNameMap[$key];
                }

                if (is_object($value) && method_exists($value, "getAll")) {
                    $result[$propNameMap] = $this->toArrayRecursive($value->getAll());
                } else {
                    if ($value !== null) {
                        $result[$propNameMap] = $this->toArrayRecursive($value);
                    }
                }
            }
            return $result;
        }
        return $data;
    }
}
