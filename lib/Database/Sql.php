<?php 
class Database_Sql{
    protected $_where = [];
    public function where($field, $value)
    {
        $this->_where[]=['fl'=>$field ,'v' => $value];
        return $this;
    }
    
}
?>