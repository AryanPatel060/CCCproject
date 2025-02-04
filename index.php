<?php
include_once("lib/config.php");



// $m = Request::getquery('m');
// $a = Request::getQuery('a');

// include_once(BASE_DIRECTORY . $m . "/" . $a . ".php");

// include("./templates/1column.php");

class Ccc {
    public static $as;
    public static function run()
    {
        $http = new Http();
        $module = $http->getModule();
        $view = $http->getView();
        $action = $http->getAction();

        // $xyz = new Admin_Code_Product();
        // $xyz->list();

        $str = $module."_Code_".$view;
        $n = new $str();
        $n->$action();

    }
}
Ccc::run();

