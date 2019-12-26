<?php

include './class/checkout.php';

$t_pricingRulePath = './json/pricingRule.json';
$t_currency = '$';

//Get the pricing rule;
if (!file_exists($t_pricingRulePath)) {
  echo 'Invalid pricing rule path: ' . $t_pricingRulePath;
  exit;
}
$t_dataReturn = file_get_contents($t_pricingRulePath);
$a_pricingRule = json_decode($t_dataReturn, true);

//Get the product from the console.log
$cls_checkout = new CheckOut($a_pricingRule);

//Continue to read user product
$t_content = readline('SKUs Scanned:');

//Replace all the space 
$t_content = str_replace(' ', '', trim($t_content));
$a_product = explode(',', $t_content);


//Scan the product
foreach ($a_product as $t_singleProduct) {
  $cls_checkout->fn_scan($t_singleProduct);
}

//Print the totals
$f_total = $cls_checkout->fn_total();
echo 'Total Expected: ' . $t_currency . $f_total;
