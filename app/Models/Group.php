<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;


      protected $table = 'groups';
    protected $primaryKey = 'group_id';

    protected $fillable = [
    
        'group_name',
        'active',
    ];


    public function group_subjects(){
        return $this->hasMany(GroupSubject::class, 'group_id', 'group_id');
    }

}
