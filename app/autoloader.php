<?php
class Autoloader {
    public function __construct() {
        spl_autoload_register(array($this, 'loader'));
    }
    private function loader($class) {
        include "classes/{$class}.php";
    }
}