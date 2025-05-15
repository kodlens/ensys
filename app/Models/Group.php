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


    public function subject(){
        return $this->hasOne(Subject::class, 'subject_id', 'subject_id');
    }

    public function semester(){
        return $this->hasOne(Semester::class, 'semester_id', 'semester_id');
    }

}
