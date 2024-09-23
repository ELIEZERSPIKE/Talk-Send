<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function creator(){
        return $this->belongsTo(User::class, 'creator_id')->select('id', 'name');
    }

    public function group_member(){
        return $this->hasmany(GroupMember::class, 'group_id');
    }
}
