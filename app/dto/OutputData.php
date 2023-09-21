<?php

namespace app\dto;

use JsonSerializable;

class OutputData implements JsonSerializable{
  private float $price;
  private string $date;
  private string $error;

  public function __construct($price=0, $date='', $error = null){
    $this->price = $price;
    $this->date=$date;
    if($error !== null){
      $this->error = $error;
    }
  }

  public function jsonSerialize(){
    return get_object_vars($this);
  }

  public function __get($property){
    if(property_exists($this, $property)){
      return $this->$property;
    }
  }
}
