<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class ChatFile extends Model
{
    use HasFactory;
    protected $fillable = ['group_id', 'file_name', 'file_path', 'file_type'];
    public function group(){
        return $this->belongsTo(Group::class);
    }
}
