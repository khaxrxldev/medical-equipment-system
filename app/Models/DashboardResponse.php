<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardResponse extends Model
{
  use HasFactory;

  protected $fillable = [
    // admin dashboard response
    'totalStaff',
    'totalClient',
    'totalEquipment',
    'totalApplication',

    // client dashboard response
    'equipmentName',
    'equipmentImage',
    'totalUnavailableEquipment',
    'totalAvailableEquipment',
  ];
}