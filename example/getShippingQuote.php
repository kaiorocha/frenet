<?php

require ('../vendor/autoload.php');
require ('../src/Shipping/Shipping.php');

$test = new \Shipping\Shipping();

print_r($test::getShippingQuote([
    'itens' => [
        [
            'weight' => 1,
            'length' => 1,
            'height' => 1,
            'width' => 1,
            'diameter' => 0,
            'sku' => 'SKU-001',
            'category' => 'Tests',
            'isFragile' => false,
        ]
    ],
    'cep' => '07716135',
    'total' => 109.90
]));