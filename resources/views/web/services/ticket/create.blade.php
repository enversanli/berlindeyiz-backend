@extends('web.layouts.app')

@section('site-title', $service->title . ' - Berlindeyiz Bilet')
@section("og-image", config('app.url'). '/storage/'.$service->logo)

@section('site-description', $service->title . ' bileti satın almak için formu doldurunuz.')


@if(isset($service->meta['keywords']) && $service->meta['keywords']  != null)
    @section('site-keywords', $service->meta['keywords'])
@endif

@section('content')
    <div class="">
        <service-ticket-create :service="{{$service}}"></service-ticket-create>
    </div>
@endsection
