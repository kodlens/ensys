@extends('layouts.admin')

@section('content')
    <enrollee-update-status :prop-id="{{$id}}"
        :prop-data='@json($enroll)'></enrollee-update-status>
@endsection

