@extends('web.layouts.app')

@section('title', __('dashboard/comment.comments'))

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
            @php
            $type = request()->type;
            $category = request()->category;
            $date = request()->tarih;
            @endphp
    <div class="py-10">
        <searched-service-component type="{{$type}}" category="{{$category}}" date="{{$date}}"></searched-service-component>
    </div>
@endsection
