<?php

namespace app\dto\slowShippingDto;

use app\facades\CarrierOutputDto;

class SlowShippingOutputDto implements CarrierOutputDto {
  private string $sourceKladr;
  private string $targetKladr;
  private float $weight;

  public function __construct($source, $target, $weight){
    $this->sourceKladr = $source;
    $this->targetKladr = $target;
    $this->weight = $weight;
  }

  public function __get($property){
    if(property_exists($this, $property)){
      return $this->$property;
    }
  }
}
