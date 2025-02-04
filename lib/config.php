<?php
define('BASE_DIRECTORY', 'C:/xampp/htdocs/project');
define('BASE_URL', 'http://localhost/project');
include("db.php");

spl_autoload_register(function ($class) {
    $_file = str_replace('_', '/', $class);
    include_once BASE_DIRECTORY.(sprintf("/lib/%s.php", $_file));
});
spl_autoload_register(function ($class) {
    $_file = str_replace('_', '/', $class);
    include_once BASE_DIRECTORY.(sprintf("/%s.php", $_file));
});

