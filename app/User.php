<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];

    const USER_VERIFIED = '1';
    const USER_NOT_VERIFIED = '0';

    const USER_ADMIN = 'true';
    const USER_REGULAR = 'false';

    public $transformer = UserTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified', 'discount', 'verification_token', 'admin'
    ];

    protected $appends = [
        'full_name'
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtolower($valor);
    }

    public function getFullNameAttribute(){
        if ($this->profile) {
            return "{$this->name} {$this->profile->surnames }";
        }

        return "{$this->name}";
    }

    public function getNameAttribute($valor)
    {
        return ucwords($valor);
    }

    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /* public function findForPassport($username)
    {
        return $this->orWhere('email', $username)->where('verified', 1)->first();
    }*/



    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified(){
        return $this->verified == USER::USER_VERIFIED;
    }

    public function isAdmin(){
        return $this->admin == USER::USER_ADMIN;
    }

    public static function generateVerificationToken(){
        return Str::random(40);
    }
}
