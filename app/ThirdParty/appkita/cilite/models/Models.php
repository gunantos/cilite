<?php
namespace appkita\cilite\models;
use \appkita\cilite\types\TypeModel;

class  Models {
    /**
     * @var array $_temp
     */
    private $_temp = [];

    /**
     * @var array $_items
     */
    private $_items = [];

    /**
     * magic class php
     * set property and initiali to $_items
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, mixed $val): void
    {
        if (!isset($this->_items[$name])) {
            $value = new TypeModel($key, $val);
            $this->{$name} = $value;
            $_items[$name] = $value;
        }
    }
    /**
     * magic class php
     * get property
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (isset($this->_items[$name])) {
            return $this->_items[$name];
        }
        return null;
    }

    /**
     * get all public property in this class and set to $_items 
     */
    public function __construct()
    {
       $this->_init();
    }

    /**
     * initiali property to $_items;
     */
    private function _init() {
         $this->_items = $this->_from_reflection((new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC));
    }
    /**
     * convert from reflection result to array multideminsion with key => value
     * @param array $reflection 
     * @return array
     */
    private function _from_reflection(array $reflection) : array
    {
        $itm = [];
        foreach ($reflection as $key) {
            $itm[$key->getName()] =  $this->{$key->getName()};
        }
        return $itm;
    }

    /**
     * magic class php 
     * convert to string, create result object form property
     * @return string
     */
    function __toString()
    {
        return $this->_items;
    }

    /**
     * magic class php
     * convert class to array map
     * @return array
     */
    public function __serialize() : array
    {
        return $this->_items;
    }

    /**
     * magic class php
     * @set property on class from array
     * @param array $data
     */
    public function __unserialize(array $data) : void
    {
        foreach($data as $key => $val) {
            if (isset($this->_items[$key])) {
                $value = new TypeModel($key, $val);
                $this->{$key} = $value;
                $this->_items[$key] = $value;
            }
        }
    }
    /**
     * magic method class php
     * call
     * @param string $name
     * @param array $arguments
     * @return mixed|null
     */
    public function __call(string $name, array $arguments) : mixed
    {
        if (isset($this->_items[$name])) {
            return $this->_items[$name];
        }
        return null;
    }
}