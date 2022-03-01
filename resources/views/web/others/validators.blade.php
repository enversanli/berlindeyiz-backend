@extends('web.layouts.app')

@section('content')
    <div class="py-10">
        <validator-component :validators="{{$validators}}"></validator-component>
    </div>
@endsection
