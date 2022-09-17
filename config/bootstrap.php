<?php

spl_autoload_register(function ($class_name) {
    
    $potential_app_file_name = ROOT_PATH . 'src' . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class_name) . '.php';
    
    if (file_exists($potential_app_file_name)) {
        require $potential_app_file_name;
    }
    
    $potential_lib_file_name = ROOT_PATH . 'lib' . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class_name) . '.php';
    
    if (file_exists($potential_lib_file_name)) {
        require $potential_lib_file_name;
    }
});
