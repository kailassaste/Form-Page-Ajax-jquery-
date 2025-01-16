<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'state_id'];

    protected $table = 'cities';
    
     // Relationship with State model
     
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    
     // Relationship with User model
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getCitiesByState($stateId)
    {
        return City::where('state_id', $stateId)->get();
    }
}
