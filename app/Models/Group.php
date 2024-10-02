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
        // 'avatar',
        
        'description',
    ];
//    protected $table = 'groups';
  


    // public function invites() {
    //     return $this->belongsToMany(invite::class, 'group_members');
    // }


    public function Files(){
        return $this->hasMany(File::class);
     }

    public function members(){
        return $this->hasMany(MembreGroup::class);
    }

    public function users(){
  return $this->members->where('member_type', 'user');    
   }

   public function invites(){
    return $this->members->where('member_type', 'invite');    
     }










}
