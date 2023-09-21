<?php

namespace app\dto\slowShippingDto;

use app\facades\CarrierInputDto;

class SlowShippingInputDto implements CarrierInputDto {
  private float $coefficient;
  private string $date;
  private string $error;

  public function __construct($coefficient, $date, $error = null){
    $this->coefficient = $coefficient;
    $this->date = $date;
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
