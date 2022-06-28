@extends('layouts.app')


{{--continer--}}
@section('continer')
    <h3>User Profile</h3>
{{--    <h4>Id View:{{ $id }}</h4>--}}
{{--    <h4>Id Code:{{ $code }}</h4>--}}
    <hr>
    @foreach($names as $name)
        <h4>Name is: {{ $name }}</h4>
    @endforeach
@endsection


{{--Footer--}}
@section('footer')
    <h6>footer</h6>
@endsection
