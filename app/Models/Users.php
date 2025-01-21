<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Users extends Model
{
    //
    use HasFactory;

    protected $table = 'users';

    protected $fillable=[
        'name', 'email', 'mobile_no', 'gender_ID','city_ID','password','profile_photo',
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class,'gender_ID');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_ID');
    }

    public function createdBy( $data)
    {
        $data['password'] = Hash::make($data['password']);
        
        $user = Users::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'gender_ID' => $data['gender_id'],
            'city_ID' => $data['city_id'],
            'password' => $data['password'],
            'profile_photo' => $data['profile_photo'] ?? null,
        ]);
    
        return $user;
    }

    public function updatedBy()
    {
        return $this->select('users.*','genders.name as gender_name', 'cities.name as city_name','countries.name as country_name',
            'users.updated_at as updated_at','updated_by.name as updated_by_name' )
        ->join('genders', 'users.gender_ID', '=', 'genders.id')
        ->join('cities', 'users.city_ID', '=', 'cities.id')
        ->join('states', 'cities.state_id', '=', 'states.id')
        ->join('countries', 'states.country_id', '=', 'countries.id')
        ->join('users as updated_by', 'users.updated_by', '=', 'updated_by.id')
        ->get();
    }

    public function deletedBy()
    {
        return $this->select('users.*','users.deleted_at as deleted_at','deleted_by.name as deleted_by_name')
        ->join('users as deleted_by', 'users.deleted_by', '=', 'deleted_by.id')
        ->get();
    }

    public function getAllUsers()
    {
        return $this->select('users.*', 'genders.name as gender_name', 'cities.name as city_name', 'countries.name as country_name')
        ->join('genders', 'users.gender_ID', '=', 'genders.id') 
        ->join('cities', 'users.city_ID', '=', 'cities.id')  
        ->join('states', 'cities.state_id', '=', 'state_id')
        ->join('countries', 'states.country_id', '=', 'countries.id') 
        ->get();
    }
}
