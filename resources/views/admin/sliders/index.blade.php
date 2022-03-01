<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="mt-24 space-y-20">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        @if(Session::has('message'))
                                            @php $message = Session::get('message') @endphp
                                        @endif

                                        @if(isset($message))
                                            <div
                                                class="bg-{{$message['color']}}-100 border border-{{$message['color']}}-400 text-{{$message['color']}}-700 px-4 py-3 rounded relative"
                                                role="alert" style="margin-bottom: 30px">
                                                <strong class="font-bold">{{$message['title']}}</strong>
                                                <span class="block sm:inline">{{$message['content']}}</span>
                                            </div>
                                        @endif
                                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                                        <h1 class="text-center text-2xl mb-10 uppercase">@lang('common.sliders')</h1>
                                        @if($sliders->count() > 0)
                                            <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-10">
                                                @foreach($sliders as $slider)
                                                    <div
                                                        class="relative h-64 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3 animate__animated animate__fadeIn">
                                                        <div class="absolute top-0 left-0 right-0 bottom-10">
                                                            <img class="w-full h-full"
                                                                 src="{{$slider->image}}">
                                                        </div>

                                                        <div
                                                            class="absolute bottom-0 right-0 left-0 h-9 bg-danger text-center z-10 w-full">
                                                            <button type="submit"
                                                                    onclick='modalShow("{{route('slider.destroy', $slider->id)}}")'
                                                                    class="p-1  pl-3 pr-3 transition-colors w-full h-full duration-500 transform bg-red-500 hover:bg-red-400 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">
                                                                <i class="far fa-trash-alt"></i> @lang('common.delete')
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="w-full text-center text-2xl border p-3 my-5">
                                                <p>@lang('common.not_found_slider')</p>
                                            </div>
                                        @endif
                                        <hr>
                                        <form action="{{route('slider.store')}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <h1 class="mt-10 text-2xl text-center uppercase">@lang('common.create_new_slider')</h1>
                                            <div class="grid grid-cols-2 w-full items-center justify-end mt-10 mb-10">
                                                <div>
                                                    <input type="file" name="slider" class="bg-white" required>
                                                </div>
                                                <div>
                                                    <x-button class="ml-3 float-right">
                                                        <i class="fas fa-plus"></i> {{ __('common.create') }}
                                                    </x-button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
