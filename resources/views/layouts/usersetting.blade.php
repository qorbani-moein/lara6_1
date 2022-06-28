@extends('layouts.app')

@section('continer')
    @if(count($usersAdmin))
        <ul>
        @foreach($usersAdmin as $userAdmin)
            <li>{{$userAdmin}}</li>
        @endforeach
        </ul>
    @endif
@endsection
