<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SigninResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'responseId',
        'responseRole',
        'responseStatus',
        'responseMessage'
    ];
}