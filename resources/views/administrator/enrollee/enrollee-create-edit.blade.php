@extends('layouts.admin')

@section('content')

    <enrollee-create-edit
        prop-data='@json($data)'
        :prop-data-id="{{ $id }}"></enrollee-create-edit>
   
@endsection

