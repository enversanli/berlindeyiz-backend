@extends('web.layouts.app')

@section('content')
    <div class="py-10">
        <faq-component :questions="{{$questions}}"></faq-component>
    </div>
@endsection
