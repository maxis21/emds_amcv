<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model
{
    use HasFactory;

    protected $table = 'tbl_document_versions';

    protected $fillable = [
        'name',
        'file_url',
        'document_id',
        'uploaded_by'
    ];

    public function document(){
        return $this->belongsTo(Document::class);
    }
}
