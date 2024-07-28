<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  use HasFactory;

  protected $fillable = [
    'paymentId',
    'paymentAmount',
    'paymentReceipt',
    'paymentStatus',
    'paymentDate',
    'applicationId'
  ];

  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';
  protected $primaryKey = 'paymentId';
}
