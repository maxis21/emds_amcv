<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'tbl_transaction_history';

    protected $fillable = [
        'reference_id',
        'action_taken'
    ];

    public function requests(){
        return $this->hasMany(Request::class, 'id');
    }

    public function document(){
        return $this->belongsTo(Document::class);
    }

    
}
