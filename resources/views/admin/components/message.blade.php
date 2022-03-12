@if(\Illuminate\Support\Facades\Session::has('status'))
    @php
        $status = \Illuminate\Support\Facades\Session::get('status');
        $color = \Illuminate\Support\Facades\Session::get('color');
        $title = \Illuminate\Support\Facades\Session::get('title');
        $message = \Illuminate\Support\Facades\Session::get('message');
    @endphp
@endif

@if(isset($status))
    <div
            class="bg-{{$color}}-100 border border-{{$color}}-400 text-{{$color}}-700 px-4 py-3 rounded relative"
            role="alert" style="margin-bottom: 30px">
        <strong class="font-bold">{{$title}}</strong>
        <span class="block sm:inline">{{$message}}</span>
    </div>
@endif