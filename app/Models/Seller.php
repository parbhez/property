<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Seller extends Authenticatable
{
     use  Notifiable,HasFactory,HasRoles;

     Protected $guard_name ='seller';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'firstName',
        'lastName',
        'facebook',
        'facebook',
        'fax',
        'linkedin',
        'license',
        'about',
        'skype',
        'address',
        'is_approved',
    ];



    public function getFullNameAttribute()
    {
        return ucwords($this->firstName. ' '.$this->lastName);
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}