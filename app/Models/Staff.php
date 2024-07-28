<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
  use HasFactory;

  protected $fillable = [
    'staffId',
    'staffIcNumber',
    'staffName',
    'staffEmail',
    'staffPhoneNo',
    'staffAddress',
    'staffRole',
    'staffPassword'
  ];

  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';
  protected $primaryKey = 'staffId';
}
