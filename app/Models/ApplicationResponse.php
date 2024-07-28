<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationResponse extends Model
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
    'applicationColor',
    'clientId',
    'clientName',
    'staffId',
    'staffName',
    'equipmentId',
    'equipmentName',
    'paymentId',
    'paymentStatus',
    'paymentDate',
    'paymentColor',
    'returnId',
    'returnCondition',
    'adminNotiStatus',
    'clientNotiStatus'
  ];
}