<?php
class Database_Sql
{
    protected $_where = []; 
    public function where($field, $value)
    {  
        if(is_array($value))
        {
            foreach($value as $operator => $val)
            {
                $this->_where[] = "{$field} {$operator} '{$val}'";
            }
        }
        else {
            $this->_where[] = "{$field} = '{$value}'";
        }
        return $this;
    }
}
