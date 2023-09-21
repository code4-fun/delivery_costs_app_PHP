<?php

namespace app\dto;

class InputData{
  private string $carrier;
  private string $sourceKladr;
  private string $targetKladr;
  private float $weight;

  public function __construct($carrier, $sourceKladr, $targetKladr, $weight){
    $this->carrier = $carrier;
    $this->sourceKladr = $sourceKladr;
    $this->targetKladr = $targetKladr;
    $this->weight = $weight;
  }

  public function __get($property){
    if(property_exists($this, $property)){
      return $this->$property;
    }
  }
}
