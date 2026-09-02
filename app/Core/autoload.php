<?php

//autoload pra nao usar composer

spl_autoload_register(function($class){
    $prefixo = 'App\\';
    $base_dir = __DIR__ . '/../';

    if(strncmp($prefixo, $class, strlen($prefixo)) !== 0){
        return;
    }

    $relative_class = substr($class, strlen($prefixo));
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if(file_exists($file)){
        require $file;
    }
});