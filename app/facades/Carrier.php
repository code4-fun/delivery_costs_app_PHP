<?php

namespace app\facades;

use app\dto\OutputData;

interface Carrier{
  public function calculateTotalCost():OutputData;
  public function callApi(CarrierOutputDto $dto, string $uri):CarrierInputDto;
}
