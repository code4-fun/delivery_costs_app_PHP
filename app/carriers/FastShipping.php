<?php

namespace app\carriers;

use app\dto\fastShippingDto\FastShippingInputDto;
use app\dto\fastShippingDto\FastShippingOutputDto;
use app\dto\OutputData;
use app\facades\Carrier;
use app\facades\CarrierInputDto;
use app\facades\CarrierOutputDto;
use DateTime;

class FastShipping implements Carrier{
  private string $base_url = 'https://fastshipping.com';
  private string $sourceKladr;
  private string $targetKladr;
  private float $weight;

  public function __construct($sourceKladr, $targetKladr, $weight){
    $this->sourceKladr = $sourceKladr;
    $this->targetKladr = $targetKladr;
    $this->weight = $weight;
  }

  public function calculateTotalCost():OutputData{
    $output_dto = new FastShippingOutputDto($this->sourceKladr, $this->targetKladr, $this->weight);
    $carrier_response = $this->callApi($output_dto, $this->base_url);

    if($carrier_response->error !== ''){
      return new OutputData(0, '', $carrier_response->error);
    }

    $date = (new DateTime())->modify('+'.$carrier_response->period.' days');
    $price = floor($carrier_response->price * 100)/100;
    return new OutputData($price, $date->format('Y-m-d'), '');
  }


  public function callApi(CarrierOutputDto $dto, string $uri): CarrierInputDto{
    $price = rand(100, 150) * $dto->weight;
    $now = new DateTime();

    if($dto->sourceKladr === '' || $dto->targetKladr === '' || $dto->weight === '' || $dto->weight == 0 || !isset($uri)){
      return new FastShippingInputDto(0, 0, 'required data is missing');
    }

    if((integer)$now->format('H') > 18){
      return new FastShippingInputDto(0, 0, 'closed until tomorrow');
    }

    $period = rand(5, 15);
    return new FastShippingInputDto($price, $period, '');
  }

  public function __get($property){
    if(property_exists($this, $property)){
      return $this->$property;
    }
  }
}
