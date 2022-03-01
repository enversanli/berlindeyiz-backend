@extends('web.layouts.app')

@section('content')
    <div class="py-10">
        <announcement-component :announcements="{{$announcements}}"></announcement-component>
    </div>
@endsection
