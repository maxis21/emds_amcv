<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'tbl_requests';

    protected $fillable = [
        'user_id',
        'document_id',
        'request_status',
        'file_url',
    ];

    public function document(){
        return $this->belongsTo(Document::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transaction(){
        return $this->belongsTo(transaction::class);
    }
}
