<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class UserOtp extends Model
{
    protected $fillable =[
        'otp',
        'expires_at',
        'user_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isExpired(){
       return $this->required_at->isPast();
    }
}
