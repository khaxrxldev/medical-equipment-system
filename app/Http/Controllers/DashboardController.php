<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\Staff;
use App\Models\ReturnModel;
use App\Models\DashboardResponse;

class DashboardController extends Controller
{
  public function adminDashboard()
  {
    $dashboardResponse = new DashboardResponse();

    $dashboardResponse -> totalStaff = Staff::count();
    $dashboardResponse -> totalClient = Client::count();
    $dashboardResponse -> totalEquipment = Equipment::count();
    $dashboardResponse -> totalApplication = Application::count();

    return response() -> json(array('data' => $dashboardResponse), 200);
  }

  public function clientDashboard()
  {
    $dashboardResponses = [];
    $equipments = Equipment::all();
    
    foreach ($equipments as $equipment) {
      $dashboardResponse = new DashboardResponse();

      $totalEquipment = $equipment -> equipmentQuantity;

      $totalAvailable = 0;
      $totalUnavailable = 0;

      $applications = Application::where('equipmentId', $equipment -> equipmentId) -> get();

      if (!$applications -> isEmpty()) {
        // application for the equipment - all equipment available
        foreach ($applications as $application) {
          $return = ReturnModel::where('applicationId', $application -> applicationId) -> first();
          
          if ($return) {
            if (!$return -> returnCondition) {
              // check if application already return
              $totalUnavailable = $totalUnavailable + $application -> applicationQuantity;
            }
          }
        }

        $totalAvailable = $equipment -> equipmentQuantity - $totalUnavailable;
      } else {
        // no application for the equipment - all equipment available
        $totalAvailable = $totalEquipment;
      }
      
      $dashboardResponse -> equipmentName = $equipment -> equipmentName;
      $dashboardResponse -> equipmentImage = $equipment -> equipmentImage;
      $dashboardResponse -> totalEquipment = $totalEquipment;
      $dashboardResponse -> totalAvailableEquipment = $totalAvailable;
      $dashboardResponse -> totalUnavailableEquipment = $totalUnavailable;

      $dashboardResponses[] = $dashboardResponse;
    }

    return response() -> json(array('data' => $dashboardResponses), 200);
  }
}
