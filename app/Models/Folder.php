<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $table = 'tbl_folder';

    protected $fillable = [
        'name',
        'parent_id',
        'department_id'
    ];

     /**
     * Get the parent folder of the current folder.
     */
    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    /**
     * Get the child folders of the current folder.
     */
    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getAncestors(){
        $ancestors = collect();
        $folder = $this;
        $parent = $this->parent;

        while($folder){
            $ancestors->prepend($folder);
            $folder = $folder->parent;
        }

        return $ancestors;
    }

}
