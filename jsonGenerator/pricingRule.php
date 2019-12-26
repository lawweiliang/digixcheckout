<?php

$a_pricingRule = [
  [
    'a_condition' => [
      't_productId' => 'atv',
      't_operator' => '>=',
      'i_value' => 2
    ],
    'a_action' => [
      't_productId' => 'atv',
      't_type' => 'quantity',
      't_value' => '-no_of_product_percent_2'
    ]
  ],
  [
    'a_condition' => [
      't_productId' => 'ipd',
      't_operator' => '>=',
      'i_value' => 4
    ],
    'a_action' => [
      't_productId' => 'ipd',
      't_type' => 'price',
      't_value' => '-50'
    ]
  ],
  [
    'a_condition' => [
      't_productId' => 'mbp',
      't_operator' => '>',
      'i_value' => 0
    ],
    'a_action' => [
      't_productId' => 'vga',
      't_type' => 'quantity',
      't_value' => '-no_of_product'
    ]
  ]

];

// echo json_encode($a_product, JSON_PRETTY_PRINT);

//Save the product array into a product json file
$fp = fopen('../json/pricingRule.json', 'w');
fwrite($fp, json_encode($a_pricingRule, JSON_PRETTY_PRINT));
fclose($fp);

echo 'Successfully create pricingRule.json file';
