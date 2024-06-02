<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'ic_number', 'address', 'contact', 'email', 'password', 
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
