<?php
class Request
{
    public static function getParams() {}
    public static function getparam($field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        } else {
            return '';
        }
    }
    public static function getQuery($field)
    {
        if (isset($_GET[$field])) {
            return $_GET[$field];
        } else {
            return '';
        }
    }
}
