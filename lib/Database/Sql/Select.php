<?php
class Database_Sql_Select extends Database_Sql
{

    protected $_table = '';
    protected $_columns = '*';
    protected $_where = [];


    public function select($table, $columns)
    {
        $this->_table = $table;
        $this->_columns = $columns;
        return $this;
    }
    
    
   

    public function __toString() {
        return  $sql = "SELECT * FROM tablename";

    }
}
