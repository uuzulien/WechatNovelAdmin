<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUsers extends Model
{
    public $table = 'group_users';
    public $connection = 'admin';
}
