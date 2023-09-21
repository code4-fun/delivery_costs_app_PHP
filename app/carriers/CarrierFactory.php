<?php

namespace app\carriers;

use app\dto\InputData;
use app\facades\Carrier;
use Exception;

class CarrierFactory{
  public static function getCarrier(InputData $input_data):Carrier{
    switch($input_data->carrier){
      case 'fast_shipping':
        return new FastShipping($input_data->sourceKladr, $input_data->targetKladr, $input_data->weight);
      case 'slow_shipping':
        return new SlowShipping($input_data->sourceKladr, $input_data->targetKladr, $input_data->weight);
      default:
        throw new Exception('shipping company is missing');
    }
  }
}
