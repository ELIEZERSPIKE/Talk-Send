<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        
        'description',
    ];

    // public function members(): HasMany{
    //     return $this->hasMany(User::class, 'group_user');
    // }


    public function invites() {
        return $this->belongsToMany(invite::class, 'group_members');
    }

    public function Files(){
        return $this->hasMany(File::class);
    }
}
