<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'description'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function messages(){
//        return $this->hasMany(Messages::class);
    }
}
