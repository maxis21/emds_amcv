<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $table = 'tbl_user_roles';

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function role(){
        return $this->hasOne(Role::class);
    }
}
