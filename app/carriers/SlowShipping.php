<?php

namespace app\carriers;

use app\dto\OutputData;
use app\dto\slowShippingDto\SlowShippingOutputDto;
use app\dto\slowShippingDto\SlowShippingInputDto;
use app\facades\Carrier;
use app\facades\CarrierInputDto;
use app\facades\CarrierOutputDto;
use DateTime;

class SlowShipping implements Carrier{
  private string $base_url = 'https://slowshipping.com';
  private int $base_price = 150;
  private string $sourceKladr;
  private string $targetKladr;
  private float $weight;

  public function __construct($sourceKladr, $targetKladr, $weight){
    $this->sourceKladr = $sourceKladr;
    $this->targetKladr = $targetKladr;
    $this->weight = $weight;
  }

  public function calculateTotalCost():OutputData{
    $output_dto = new SlowShippingOutputDto($this->sourceKladr, $this->targetKladr, $this->weight);
    $carrier_response = $this->callApi($output_dto, $this->base_url);

    if($carrier_response->error !== ''){
      return new OutputData(0, '', $carrier_response->error);
    }

    $price = floor($carrier_response->coefficient * $this->base_price * $this->weight * 100)/100;
    return new OutputData($price, $carrier_response->date, '');
  }


  public function callApi(CarrierOutputDto $dto, string $uri): CarrierInputDto{
    $coefficient = rand(100, 150)/100;

    if($dto->sourceKladr === '' || $dto->targetKladr === '' || $dto->weight === '' || $dto->weight == 0 || !isset($uri)){
      return new SlowShippingInputDto(0, 0, 'required data is missing');
    }

    $num_of_days = rand(3, 15);
    $date = (new DateTime())->modify('+'.$num_of_days.' days')->format('Y-m-d');

    return new SlowShippingInputDto($coefficient, $date, '');
  }

  public function __get($property){
    if(property_exists($this, $property)){
      return $this->$property;
    }
  }
}
