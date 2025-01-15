<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name'];

    
     // Relationship with the User model
     
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
