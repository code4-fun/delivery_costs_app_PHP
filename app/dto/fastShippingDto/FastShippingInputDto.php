<?php

namespace app\dto\fastShippingDto;

use app\facades\CarrierInputDto;

class FastShippingInputDto implements CarrierInputDto{
  private float $price;
  private int $period;
  private string $error;

  public function __construct($price, $period, $error = null){
    $this->price = $price;
    $this->period = $period;
    if($error !== null){
      $this->error = $error;
    }
  }

  public function __get($property){
    if(property_exists($this, $property)){
      return $this->$property;
    }
  }
}
