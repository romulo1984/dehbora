<?php
class Autoloader {
    public function __construct() {
        spl_autoload_register(array($this, 'loader'));
    }
    private function loader($class) {
        $path = "classes/{$class}.php";
        if(file_exists($path)){
            include $path;
        }
    }
}