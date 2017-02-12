<?php

function getProductLines($file) {
    return file($file);
}

function getProductObjectFromId($id, $productName) {
    return new Product($id, $productName);
}

function getNameFromLine($line) {
    if(preg_match("/.*-(.*)\s\d+/", $line, $array)) {
        return str_replace('_', ',', $array[1]);
    }
}

function getIdFromLine($line) {
    if(preg_match("/^(\d{1,3})-/", $line, $array)) {
        return $array[1];
    }
    return -1;
}

class Product {
    public $id;
    public $name;

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
}

$lines = getProductLines("test.txt");
$objects = array();
foreach($lines as $line) {
    $id = getIdFromLine($line);
    $name = getNameFromLine($line);
    $objects[$id] = getProductObjectFromId($id, $name);
}

class ProductFacade {

    private $products = array();

    function __construct($file) {
        $this->file = $file;
        $this->compile();
    }

    private function compile() {
        $lines = getProductLines($this->file);
        foreach($lines as $line) {
            $id = getIdFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromId($id, $name);
        }
    }

    function getProducts() {
        return $this->products;
    }

    function getProduct($id) {
        if(isset($this->products[$id])){
            return $this->products[$id];
        }
        return null;
    }
}

$facade = new ProductFacade("test.txt");
var_dump($facade->getProduct(234));