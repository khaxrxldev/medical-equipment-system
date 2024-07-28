<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnModel extends Model
{
  use HasFactory;

  protected $fillable = [
    'returnId',
    'returnDate',
    'returnCondition',
    'returnEvidence',
    'applicationId'
  ];

  public $timestamps = false;
  public $incrementing = false;
  protected $keyType = 'string';
  protected $primaryKey = 'returnId';
}
