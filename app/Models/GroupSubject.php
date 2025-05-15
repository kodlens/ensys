<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSubject extends Model
{
    use HasFactory;

    protected $table = 'group_subjects';
    protected $primaryKey = 'group_subject_id';

    protected $fillable = [
        'group_id',
        'subject_id',
        'semester_id',
        'name',
        'description'
    ];


    public function subject(){
        return $this->hasOne(Subject::class, 'subject_id', 'subject_id');
    }

    public function semester(){
        return $this->hasOne(Semester::class, 'semester_id', 'semester_id');
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }


}
