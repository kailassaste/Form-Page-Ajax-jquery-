<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\UserController;

class State extends Model
{
    //
    use HasFactory;

    protected $fillable =['name','counrty_id'];

    protected $table = 'states';
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(city::class);
    }

    public function getStatesByCountry($countryId)
    {
        return State::where('country_id', $countryId)->get(['id','name','country_id']);
    }
}
