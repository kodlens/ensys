<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grade_level' => ['required'],
            'balik_aral' => ['required', 'string'],
            //'psa' => ['required', 'string', 'max:15'],
            'lrn' => ['string', 'max:15'],

            'lname' => ['required', 'string', 'max:50'],
            'fname' => ['required', 'string', 'max:50'],
            'sex' => ['required', 'string', 'max:10'],
            'birthdate' => ['required'],

            'age' => ['required'],

            'mother_tongue' => ['required', 'string', 'max:50'],

            'is_indigenous' => ['required'],
            'if_yes_indigenous' => ['required_if:is_indigenous,1'],

            'is_4ps' => ['required'],
            'household_4ps_id_no' => ['required_if:is_4ps,1'],

            'current_province_id' => ['required', 'numeric'],
            'current_city_id' => ['required', 'numeric'],
            'current_barangay_id' => ['required', 'numeric'],
            //'current_zipcode' => ['max:15', 'numeric'],

            'permanent_province_id' => ['required', 'numeric'],
            'permanent_city_id' => ['required', 'numeric'],
            'permanent_barangay_id' => ['required', 'numeric'],
            //'permanent_zipcode' => ['max:15', 'string'],

            'last_grade_level' => ['required_if:balik_aral,YES'],
            'last_year_completed' => ['required_if:balik_aral,YES'],
            'last_school_attended' => ['required_if:balik_aral,YES'],
            'last_school_id' => ['required_if:balik_aral,YES'],

            'semester_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'track_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'strand_id' => ['required_if:grade_level.curriculum_code,SHS'],
        ];
    }


    public function messages()
{
        return [
            'guardian_contact_no.regex' => 'Please enter a valid Philippines mobile phone number.',

            'semester_id.required_if' => 'Curriculum is SHS, semester is required.',
            'track_id.required_if' => 'Curriculum is SHS, track is required.',
            'strand_id.required_if' => 'Curriculum is SHS, strand is required.',

            'last_grade_level_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_year_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_attended.required' => 'This field is required since you are a returnee student.',
            'last_school_id.required' => 'This field is required since you are a returnee student.',

            'current_province_id.required' => 'Current province is required.',
            'current_city_id.required' => 'Current city is required.',
            'current_barangay_id.required' => 'Current barangay is required.',

            'permanent_province_id.required' => 'Permanent province is required.',
            'permanent_city_id.required' => 'Permanent city is required.',
            'permanent_barangay_id.required' => 'Permanent barangay is required.'
        ];
    }
}
