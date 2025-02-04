<?php
class Varien_Object
{
    protected $_data = [];
    public function __construct($_data)
    {
        $this->_data = $_data;
    }
    public function __get($field)
    {
        return isset($this->_data[$field]) ? $this->_data[$field] : "";
    }
    public function __set($field, $value)
    {
        $this->_data[$field] = $value;
        return $this;
    }
    public function __call($method, $value)
    {
        $get = substr($method, 0, 3);
        $field = substr($method, 3);
        $field = $this->camelToSnake($field);
        if ($get == "get") {
            return isset($this->_data[$field]) ? $this->_data[$field] : "";
        } else if ($get == 'set') {
            $this->_data[$field] = $value;
            return $this;
        }
        throw new Exception('error function not found');
    }
    private function camelToSnake($input)
    {

        $snakeCase = preg_replace_callback(
            '/[A-Z]/',
            function ($matches) {
                return '_' . strtolower($matches[0]);
            },
            $input
        );

        return ltrim($snakeCase, '_');
    }
}
