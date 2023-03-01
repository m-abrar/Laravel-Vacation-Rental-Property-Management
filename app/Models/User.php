<?php

namespace App\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
// use Spatie\Permission\Traits\HasRoles;
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function isOwner()
    {

        $role = $this->role;
        if($role == 'owner')
        {
            return true;
        }
        return false;
    }
    public function isActive()
    {

        $active = $this->is_active;
        if($active == 1)
        {
            return true;
        }
        return false;

    }
    
    public function isAdmin()
    {

        $role = $this->role;
        if($role == 'admin')
        {
            return true;
        }
        return false;
    }

    public function can_post()
    {

        $role = $this->role;
        if($role == 'admin')
        {
            return true;
        }
        return false;
    }

    
}
