@extends('web.layouts.app')

@section('site-title', $service->title . ' - Berlindeyiz')


@section('site-description', $service->meta['seo_description'] ?? $service->title)


@if(isset($service->meta['keywords']) && $service->meta['keywords']  != null)
    @section('site-keywords', $service->meta['keywords'])
@endif

@section('sidebar')
    @parent
@endsection

@section('option') main-container-no-padding @endsection

@section('content')
    <div class="">
        <service-detail-component :service="{{$service}}"></service-detail-component>
    </div>
@endsection
