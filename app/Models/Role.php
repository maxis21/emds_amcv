<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_roles';

    protected $fillable = [
        'name'
    ];

    public function user_role(){
        return $this->hasMany(UserRole::class);
    }
}
