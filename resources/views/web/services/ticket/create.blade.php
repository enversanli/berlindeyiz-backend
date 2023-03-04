@extends('web.layouts.app')

@section('site-title', $service->title . ' Bilet Rezervasyon - Berlindeyiz')
@section("og-image", config('app.url'). '/storage/'.$service->logo)

@section('site-description', $service->title . ' bilet rezervasyonu için formu doldurabilirsiniz.')


@if(isset($service->meta['keywords']) && $service->meta['keywords']  != null)
    @section('site-keywords', $service->meta['keywords'])
@endif

@section('content')
    <div class="">
        <service-ticket-create :service="{{$service}}"></service-ticket-create>
    </div>
@endsection
