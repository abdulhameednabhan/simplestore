<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements JWTSubject,FilamentUser
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     const ROLE_ADMIN = 'ADMIN';
     const ROLE_USER = 'USER';
     const ROLE_DEFAULT = self::ROLE_USER;
 
         const ROLES = [
         self::ROLE_ADMIN => 'Admin',
       
         self::ROLE_USER => 'User',
     ];
    protected $fillable = ['name', 'email', 'password'];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin()||$this->isUser();
        
    }



    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(){
        return $this->role === self::ROLE_USER;
    }
}