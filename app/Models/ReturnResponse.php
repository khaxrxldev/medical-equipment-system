<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnResponse extends Model
{
  use HasFactory;

  protected $fillable = [
    'clientIcNumber',
    'clientName',
    'equipmentName',
    'returnDate',
    'returnCondition',
    'returnColor'
  ];
}