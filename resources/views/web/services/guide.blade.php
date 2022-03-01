@extends('web.layouts.app')

@section('title', __('dashboard/comment.comments'))

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
    <div class="py-10">
        <service-guide-component :service="{{$service}}" :youtubeImgId="{{$youtubeImgId}}"></service-guide-component>
    </div>
@endsection
