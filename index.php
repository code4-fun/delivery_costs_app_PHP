<?php
require __DIR__ . '/vendor/autoload.php';

use app\carriers\CarrierFactory;
use app\dto\InputData;
use app\dto\OutputData;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

$q = $_GET['q'];
$method = $_SERVER['REQUEST_METHOD'];

if($q === 'calculate' && $method === 'POST'){
  $payload = file_get_contents('php://input');
  $json = json_decode($payload);

  if(!isset($json->carrier) || !isset($json->sourceKladr)
    || !isset($json->targetKladr) || !isset($json->weight)){
    http_response_code(404);
    echo json_encode(new OutputData(0, '', 'required data is missing'));
    return;
  }

  $data = new InputData(
    $json->carrier,
    $json->sourceKladr,
    $json->targetKladr,
    $json->weight
  );

  try{
    $carrier = CarrierFactory::getCarrier($data);
    $output_data = $carrier->calculateTotalCost();
    if($output_data->error !== ''){
      http_response_code(404);
      echo json_encode($output_data);
      return;
    }
    echo json_encode($output_data);
  } catch(Exception $e){
    http_response_code(404);
    echo json_encode(new OutputData(0, '', $e->getMessage()));
  }
} else {
  http_response_code(404);
  echo json_encode(['error' => 'request error']);
}
