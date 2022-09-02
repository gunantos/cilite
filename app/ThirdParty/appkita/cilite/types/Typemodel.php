<?php
namespace appkita\cilite\types;

class TypeModel {
    /**
     * @var mixed $_value;
     */
    private mixed $_value = null;
    /**
     * @var string $_key
     */
    private string $_key = '';

    public function __construct(string $key, mixed $value) {
        $this->_value = $value;
        $this->_key = $key;
    }

    /**
     * @return $key
     */
    public function key() {
        return $this->_key;
    }

    /**
     * @return $value
     */
    public function value() {
        return $this->_value;
    }

    /**
     * Magic Method PHP tostring
     * @return $this->_value
     */
    public function __toString() {
        return $this->_value;
    }

    /**
     * function hashing value proverty
     * @param mixed $value
     */
    private function hash(mixed $value) : void 
    {
        $this->_value = password_hash($value, PASSWORD_BCRYPT);
    }

    /**
     * function verify hashing value proverty
     * @param string $value
     * @return bool
     */
    private function verify_hash(string $value) : bool
    {
        return password_verify($value, $this->_value);
    }
}