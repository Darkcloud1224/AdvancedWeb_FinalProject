<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ic_number', 'address', 'contact', 'email', 'password', 
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
