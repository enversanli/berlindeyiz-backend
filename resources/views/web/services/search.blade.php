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
            $date = request()->tarih;
            @endphp
    <div class="py-10">
        <searched-service-component city="{{$city}}" category="{{$category}}" date="{{$date}}"></searched-service-component>
    </div>
@endsection
