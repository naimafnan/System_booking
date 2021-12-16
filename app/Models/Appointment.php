<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Contracts\Provider;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function appUser(){
        return $this->belongsTo(User::class,'providerDetails_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function providerDetailsApp(){
        return $this->belongsTo(provider_details::class,'providerDetails_id','id');
    }
}
