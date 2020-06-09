<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['longitude', 'latitude'];
    
    public function device(){
      return $this->belongsTo(Device::class);
    }
}
