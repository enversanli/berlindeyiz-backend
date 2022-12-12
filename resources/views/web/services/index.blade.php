@extends('web.layouts.app')

@section('title', __('dashboard/comment.comments'))

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')

    @php
    $type = request()->get('type') ?? 'etkinlikler';
    $category = request()->get('category') ?? '';
    @endphp
    <div class="py-1">
        <service-component type="{{$type}}" category="{{$category}}"></service-component>
    </div>
@endsection
