<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['first_name','last_name', 'email', 'password', 'phone', 'image', 'bio'];
    protected $attributes = [
        'email_verified_at' => null,
        'bio' => 'Enter your bio',
        'phone' => 'Enter your phone',
        'image' => 'https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png',
    ];

}
