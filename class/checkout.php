<?php

class Checkout
{

  private $t_productFilePath = './json/product.json';
  private $a_product;
  private $a_orderProductCount;
  private $a_pricingRule;

  public function __construct($a_pricingRule)
  {

    //Initialize pricing rule
    $this->a_pricingRule = $a_pricingRule;

    //Load product
    $this->fn_loadProduct();
  }

  public function fn_loadProduct()
  {
    if (file_exists($this->t_productFilePath)) {
      $t_content = file_get_contents($this->t_productFilePath);
      $this->a_product = json_decode($t_content, true);

      //Initialize order product count
      foreach ($this->a_product as $a_singleProduct) {
        $this->a_orderProductCount[$a_singleProduct['t_skuId']] = 0;
      }
    } else {
      echo 'Invalid file' . $this->t_productFilePath;
    }
  }

  public function fn_scan($t_productId)
  {
    $b_check = $this->fn_checkProductExist($t_productId);

    if ($b_check)
      $this->a_orderProductCount[$t_productId]++;
    else
      echo 'Invalid Product id --> ' . $t_productId . "\n";
  }

  public function fn_checkProductExist($t_productId)
  {
    return in_array($t_productId, (array_keys($this->a_orderProductCount)));
  }

  public function fn_total()
  {
    //Go through the system condition/pricing rule
    $this->fn_filterPricingRule();

    $f_sum = 0;
    foreach ($this->a_product as $a_singleProduct) {
      $f_sum += $this->a_orderProductCount[$a_singleProduct['t_skuId']] * $a_singleProduct['f_price'];
    }

    return number_format($f_sum, 2);
  }


  public function fn_filterPricingRule()
  {
    foreach ($this->a_pricingRule as $a_singlePricingRule) {
      if ($this->fn_parseCondition($this->a_orderProductCount[$a_singlePricingRule['a_condition']['t_productId']], $a_singlePricingRule['a_condition']['t_operator'], $a_singlePricingRule['a_condition']['i_value'])) {
        foreach ($this->a_product as $i_index => $a_singleProduct) {
          if ($a_singleProduct['t_skuId'] == $a_singlePricingRule['a_action']['t_productId']) {
            if ($a_singlePricingRule['a_action']['t_type'] == 'price') {
              $this->a_product[$i_index]['f_price'] += $a_singlePricingRule['a_action']['t_value'];
            } else {
              if ($a_singlePricingRule['a_action']['t_value'] == '-no_of_product') {
                $this->a_orderProductCount[$a_singlePricingRule['a_action']['t_productId']] -= $this->a_orderProductCount[$a_singlePricingRule['a_condition']['t_productId']];
              } elseif ($a_singlePricingRule['a_action']['t_value'] == '-no_of_product_percent_2') {
                $this->a_orderProductCount[$a_singlePricingRule['a_action']['t_productId']] -= $this->a_orderProductCount[$a_singlePricingRule['a_condition']['t_productId']] % 2;
              }
            }
          }
        }
      }
    }
  }


  function fn_parseCondition($t_firstValue, $t_operator, $t_secondValue)
  {
    switch ($t_operator) {
      case '>=':
        return ($t_firstValue >= $t_secondValue);
        break;
      case '>':
        return ($t_firstValue > $t_secondValue);
        break;
      case '<=':
        return ($t_firstValue <= $t_secondValue);
        break;
      case '<':
        return ($t_firstValue < $t_secondValue);
        break;
      case '==':
        return ($t_firstValue == $t_secondValue);
        break;
    }
  }
}
