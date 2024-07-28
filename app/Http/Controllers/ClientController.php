<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\SigninResponse;

class ClientController extends Controller
{
  public function signin(Request $request)
  {
    $signinResponse = new SigninResponse();
    $existingClient = Client::where('clientIcNumber', '=', $request -> input('clientIcNumber')) -> first();

    if(!empty($existingClient)) {
      if (strcmp($existingClient -> clientPassword, $request -> input('clientPassword')) == 0) {
        $signinResponse -> responseId = $existingClient -> clientId;
        $signinResponse -> responseStatus = true;
      } else {
        $signinResponse -> responseStatus = false;
        $signinResponse -> responseMessage = 'Log masuk gagal.';
      }
    } else {
      $signinResponse -> responseStatus = false;
      $signinResponse -> responseMessage = 'Log masuk gagal.';
    }

    return response() -> json(array('data' => $signinResponse), 200);
  }

  public function readAll()
  {
    $clients = Client::all();
    return response() -> json(array('data' => $clients), 200);
  }

  public function read(string $id)
  {
    $client = Client::find($id);
    return response() -> json(array('data' => $client), 200);
  }
  
  public function create(Request $request)
  {
    $createClient = Client::create([
      'clientId' => Str::uuid() -> toString(),
      'clientIcNumber' => $request -> input('clientIcNumber'),
      'clientName' => $request -> input('clientName'),
      'clientEmail' => $request -> input('clientEmail'),
      'clientPhoneNo' => $request -> input('clientPhoneNo'),
      'clientAddress' => $request -> input('clientAddress'),
      'clientJob' => $request -> input('clientJob'),
      'clientCancerType' => $request -> input('clientCancerType'),
      'clientMembership' => $request -> input('clientMembership'),
      'clientPassword' => $request -> input('clientPassword')
    ]);

    return response() -> json(array('data' => $createClient), 200);
  }

  public function update(Request $request)
  {
    $client = Client::find($request -> input('clientId'));
    $updateClient = $client -> update($request -> all());

    if ($updateClient === true) {
      $updatedClient = Client::find($request -> input('clientId'));
      return response() -> json(array('data' => $updatedClient), 200);
    } else {
      return response() -> json(array('data' => null), 200);
    }
  }

  public function delete(string $id)
  {
    $deleteStatus = false;
    $deleteClient = Client::find($id);

    if (!empty($deleteClient)) {
      $deleteStatus = $deleteClient -> delete();
    }

    return response() -> json(array('data' => $deleteStatus), 200);
  }
}
