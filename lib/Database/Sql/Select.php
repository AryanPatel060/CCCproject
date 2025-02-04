<?php
class Database_Sql_Select extends Database_Sql
{

    protected $_table = '';
    protected $_columns = [];
    protected $_where = [];


    public function select($table, $columns)
    {
        $this->_table = $table;
        $this->_columns = $columns;
        return $this;
    }
    
    public function __toString() {
        $columns = (count($this->_columns))? implode(",",$this->_columns):"*";
        $where = "";
        if(count($this->_where))
        {
            $where .= "WHERE ".implode('AND',$this->_where);
            
        }
       return  $sql = "SELECT {$columns} FROM {$this->_table} ".$where;
    }
}
