<?php

require_once('../vendor/autoload.php');

$params = ['str_art' => 'isskescnso', 'int_art' => 56, 'arr_str' => [1,2,3]];
$tree = new \Seekwoyee\Tree('Bst', 3, $params);

var_dump($tree);