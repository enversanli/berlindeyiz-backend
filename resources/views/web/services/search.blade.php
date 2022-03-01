@extends('web.layouts.app')

@section('title', __('dashboard/comment.comments'))

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
            @php
            $category = request()->kategori;
            $city = request()->sehir;
            @endphp
    <div class="py-10">
        <searched-service-component city="{{$city}}" category="{{$category}}"></searched-service-component>
    </div>
@endsection
