<?php
include_once('db.php');
spl_autoload_register(function ($class) {
    $_file = str_replace('_', '/', $class);
    include_once(sprintf("../lib/%s.php", $_file));
});
