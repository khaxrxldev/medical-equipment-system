<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\SigninResponse;

class StaffController extends Controller
{
  public function signin(Request $request)
  {
    $signinResponse = new SigninResponse();
    $existingStaff = Staff::where('staffIcNumber', '=', $request -> input('staffIcNumber')) -> first();

    if(!empty($existingStaff)) {
      if (strcmp($existingStaff -> staffPassword, $request -> input('staffPassword')) == 0) {
        $signinResponse -> responseRole = $existingStaff -> staffRole;
        $signinResponse -> responseId = $existingStaff -> staffId;
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
    $staffList = Staff::all();
    return response() -> json(array('data' => $staffList), 200);
  }

  public function read(string $id)
  {
    $staff = Staff::find($id);
    return response() -> json(array('data' => $staff), 200);
  }

  public function create(Request $request)
  {
    $createStaff = Staff::create([
      'staffId' => Str::uuid() -> toString(),
      'staffIcNumber' => $request -> input('staffIcNumber'),
      'staffName' => $request -> input('staffName'),
      'staffEmail' => $request -> input('staffEmail'),
      'staffPhoneNo' => $request -> input('staffPhoneNo'),
      'staffAddress' => $request -> input('staffAddress'),
      'staffRole' => $request -> input('staffRole'),
      'staffPassword' => $request -> input('staffPassword')
    ]);

    return response() -> json(array('data' => $createStaff), 200);
  }

  public function update(Request $request)
  {
    $staff = Staff::find($request -> input('staffId'));
    $updateStaff = $staff -> update($request -> all());

    if ($updateStaff === true) {
      $updatedStaff = Staff::find($request -> input('staffId'));
      return response() -> json(array('data' => $updatedStaff), 200);
    } else {
      return response() -> json(array('data' => null), 200);
    }
  }

  public function delete(string $id)
  {
    $deleteStatus = false;
    $deleteStaff = Staff::find($id);

    if (!empty($deleteStaff)) {
      $deleteStatus = $deleteStaff -> delete();
    }

    return response() -> json(array('data' => $deleteStatus), 200);
  }
}
