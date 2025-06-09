<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;


    protected $table = 'sections';
    protected $primaryKey = 'section_id';

    protected $fillable = [
        'grade_level',
        'section', 
        'max'
    ];


    

    public function strand(){
        return $this->hasOne(Strand::class, 'strand_id', 'strand_id');
    }

    public function enroll(){
        return $this->hasOne(Enroll::class, 'section_id', 'section_id');
    }

    public function enrollees(){
        return $this->hasMany(Enroll::class, 'section_id', 'section_id')
            ->leftJoin('learners', 'enrolls.learner_id', 'learners.learner_id')
            ->where(function($q){
                $q->where('status', 'ADMITTED')
                    ->orWhere('status', 'ENROLLED');
            })
            ->orderBy('learners.lname', 'asc');
    }


}
