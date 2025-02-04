<?php
class Database_Sql_Delete extends Database_Sql
{
    protected $_table = '';
    protected $_where = [];
    public function delete($table)
    {
        $this->_table = $table;
        return $this;
    }
    public function __toString()
    {
        $sql =  "DELETE FROM $this->_table";
        if (!empty($this->_where)) {
            $sql .= " WHERE ";
            $sql .= implode(" AND ", $this->_where);
        }
        return $sql;
    }
}
