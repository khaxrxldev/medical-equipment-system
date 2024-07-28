<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Equipment;

use Carbon\Carbon;

class EquipmentController extends Controller
{
  public function readAll()
  {
    $equipments = Equipment::all();
    foreach ($equipments as $equipment) {
      $equipment -> equipmentBuyDate = strtoupper(Carbon::parse($equipment -> equipmentBuyDate)->format('d M Y'));
    }
    return response() -> json(array('data' => $equipments), 200);
  }

  public function read(string $id)
  {
    $equipment = Equipment::find($id);
    return response() -> json(array('data' => $equipment), 200);
  }

  public function readFile(string $id)
  {
    $equipment = Equipment::find($id);
    return response() -> json(array('data' => $equipment -> equipmentImage), 200);
  }

  public function create(Request $request)
  {
    $equipmentImage = $request -> file('equipmentImage');
    $equipmentImageContent = base64_encode($equipmentImage -> get());

    $createEquipment = Equipment::create([
      'equipmentId' => Str::uuid() -> toString(),
      'equipmentName' => $request -> input('equipmentName'),
      'equipmentBuyDate' => $request -> input('equipmentBuyDate'),
      'equipmentBuyPrice' => $request -> input('equipmentBuyPrice'),
      // 'equipmentRentPrice' => $request -> input('equipmentRentPrice'),
      'equipmentQuantity' => $request -> input('equipmentQuantity'),
      'equipmentSponsor' => $request -> input('equipmentSponsor'),
      'equipmentImage' => $equipmentImageContent,
    ]);

    return response() -> json(array('data' => $createEquipment), 200);
  }

  public function update(Request $request)
  {
    $equipmentImage = $request -> file('equipmentImage');
    $equipmentImageContent = base64_encode($equipmentImage -> get());

    $equipment = Equipment::find($request -> input('equipmentId'));

    $equipment -> equipmentName = $request -> equipmentName;
    $equipment -> equipmentBuyDate = $request -> equipmentBuyDate;
    $equipment -> equipmentBuyPrice = $request -> equipmentBuyPrice;
    // $equipment -> equipmentRentPrice = $request -> equipmentRentPrice;
    $equipment -> equipmentQuantity = $request -> equipmentQuantity;
    $equipment -> equipmentSponsor = $request -> equipmentSponsor;
    $equipment -> equipmentImage = $equipmentImageContent;

    $updatedEquipment = $equipment -> save();

    return response() -> json(array('data' => $updatedEquipment), 200);
  }

  public function delete(string $id)
  {
    $deleteStatus = false;
    $deleteEquipment = Equipment::find($id);

    if (!empty($deleteEquipment)) {
      $deleteStatus = $deleteEquipment -> delete();
    }

    return response() -> json(array('data' => $deleteStatus), 200);
  }
}
