@extends('web.layouts.app')

@section('content')
    <div class="py-1">
            <article-detail slug="{{request()->article}}"></article-detail>
    </div>
@endsection