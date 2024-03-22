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
        return $this->hasMany(DocRequest::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function document_versions()
    {
        return $this->hasMany(DocumentVersion::class);
    }

    // public function getLatestVersionUpdatedAtAttribute()
    // {
    //     Attempt to get the latest document_version's updated_at, or return 'N/A'
    //     return $this->document_versions->sortByDesc('updated_at')->first()->updated_at ?? 'N/A';
    // }
}
