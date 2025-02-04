<?php 
class Http{
    public function getModule(){
        return Request::getQuery('m');
    }
    public function getView(){
        return Request::getQuery('v');

    }
    public function getAction()
    {
        return Request::getQuery('a');

    }
}
?>