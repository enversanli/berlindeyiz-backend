@extends('web.layouts.app')

@section('title', __('dashboard/comment.comments'))

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
    <div class="py-10">
        <service-detail-component :service="{{$service}}" ></service-detail-component>
    </div>
@endsection
