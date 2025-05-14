@extends('layouts.admin')

@section('content')

    @if($id > 0)
        <group-subject-create-edit
                prop-data='@json($data)'
                :prop-data-id="{{ $id }}"></group-subject-create-edit>
    @else
        <group-subject-create-edit
                prop-data=''
                :prop-data-id="{{ $id }}"></group-subject-create-edit>
    @endif
   
@endsection

