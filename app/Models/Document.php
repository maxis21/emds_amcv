<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'tbl_documents';

    protected $fillable = [
        'name',
        'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function document_versions()
    {
        return $this->hasMany(DocumentVersion::class);
    }
}
