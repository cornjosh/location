<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['phone', 'name', 'mark'];
    
    public function user(){
      return $this->belongsTo(User::class);
    }

    public function locations(){
      return $this->hasMany(Location::class);
    }
}
