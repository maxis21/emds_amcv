<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLogs extends Model
{
    use HasFactory;

    protected $table = "tbl_access_logs";

    protected $fillable = [
        'action_taken',
        'user_id',
        'deleted_at',
        'created_at'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
