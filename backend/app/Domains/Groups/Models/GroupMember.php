<?php

namespace App\Domains\Groups\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    
    protected $table = 'group_members';
    protected $fillable = ['group_id', 'member_id', 'role', 'is_primary', 'joined_at', 'left_at'];

}