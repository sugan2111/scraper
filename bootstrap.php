<?php
require_once(dirname(__FILE__).'/vendor/autoload.php');

spl_autoload_register(function ($class) {
    if(file_exists(dirname(__FILE__) . '/' . str_replace('\\','/',$class) . '.php')) {
        require_once dirname(__FILE__) . '/' . str_replace('\\','/',$class) . '.php';  
    }
});