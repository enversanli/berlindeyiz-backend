@extends('web.layouts.app')

@section('site-title', $service->title)

@section('site-description', $service->seo_description ?? $service->title)

@if(isset($service->keywords) && $service->keywords != null)
    @section('site-keywords', $service->keywords)
@endif

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
    <div class="py-10">
        <service-detail-component :service="{{$service}}"></service-detail-component>
    </div>
@endsection
