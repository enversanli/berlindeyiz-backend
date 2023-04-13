@extends('web.layouts.app')

@section('title', __('dashboard/comment.comments'))
@section('site-description', $siteDescription)
@section('site-keyword', $siteKeyword)
@section('site-title', $siteTitle)
@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
    @php

    $type = request()->get('type') ?? $type ?? 'etkinlikler';
    $category = request()->get('category') ?? '';
    $date = request()->get('date') ?? '';
    $city = request()->get('city') ?? '';
    @endphp
    <div class="py-1">
        <service-component type="{{$type}}" category="{{$category}}" date="{{$date}}" city="{{$city}}"></service-component>
    </div>
@endsection
