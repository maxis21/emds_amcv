<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = "tbl_departments";

    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->hasMany(User::class, 'department_id');
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }
}
