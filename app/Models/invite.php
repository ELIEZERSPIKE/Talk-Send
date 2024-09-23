<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invite extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
    ];

    public function groups() {
        return $this->belongsToMany(Group::class, 'group_members');
    }

    public function Files(){
        return $this->hasMany(File::class);
    }
}
