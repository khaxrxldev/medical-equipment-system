<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
  use HasFactory;

  protected $fillable = [
    'equipmentId',
    'equipmentName',
    'equipmentBuyDate',
    'equipmentBuyPrice',
    'equipmentRentPrice',
    'equipmentQuantity',
    'equipmentSponsor',
    'equipmentImage'
  ];

  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';
  protected $primaryKey = 'equipmentId';
}
