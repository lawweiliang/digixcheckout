<?php

$a_product = [
  [
    't_skuId' => 'ipd',
    't_skuName' => 'Super iPad',
    'f_price' => 549.99
  ],
  [
    't_skuId' => 'mbp',
    't_skuName' => 'MacBook Pro',
    'f_price' => 1399.99
  ],
  [
    't_skuId' => 'atv',
    't_skuName' => ' Apple TV',
    'f_price' => 109.50
  ],
  [
    't_skuId' => 'vga',
    't_skuName' => 'VGA adapter',
    'f_price' => 30.00
  ]
];

// echo json_encode($a_product, JSON_PRETTY_PRINT);

//Save the product array into a product json file
$fp = fopen('../json/product.json', 'w');
fwrite($fp, json_encode($a_product, JSON_PRETTY_PRINT));
fclose($fp);

echo 'Successfully create product.json file';
