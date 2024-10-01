<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembreGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'user_id',
        'invite_id',
        'member_type',
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invite(){
        return $this->belongsTo(invite::class);
    }
}
