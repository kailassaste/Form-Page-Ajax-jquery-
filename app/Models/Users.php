<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    //
    use HasFactory;

    protected $fillable=[
        'name', 'email', 'mobile_no', 'gender_ID','city_ID','password','profile_photo','isActive',
        'isRelated','createdBy','updatedBy','deletedBy'
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getAllUsers()
    {
        return $this->all(); 
    }
}
