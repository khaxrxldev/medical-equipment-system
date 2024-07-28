<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
  use HasFactory;

  protected $fillable = [
    'applicationId',
    'applicationQuantity',
    'applicationStartDate',
    'applicationEndDate',
    'applicationRentPrice',
    'applicationMedicLetter',
    'applicationStatus',
    'clientId',
    'staffId',
    'equipmentId',
    'adminNotiStatus',
    'clientNotiStatus'
  ];

  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';
  protected $primaryKey = 'applicationId';
}
