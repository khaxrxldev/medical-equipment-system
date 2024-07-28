<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  use HasFactory;

  protected $fillable = [
    'clientId',
    'clientIcNumber',
    'clientName',
    'clientEmail',
    'clientPhoneNo',
    'clientAddress',
    'clientJob',
    'clientCancerType',
    'clientMembership',
    'clientPassword'
  ];

  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';
  protected $primaryKey = 'clientId';
}
