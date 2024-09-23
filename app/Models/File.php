<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'user_id',
        'invite_id',
        'group_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invite(){
        return $this->belongsTo(invite::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
}
