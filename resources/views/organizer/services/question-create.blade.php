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
                                        <form action="{{route('service-question.store', $service->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="flex w-full mobile-companent">
                                                <div class="w-full mr-3 mobile-input">
                                                    <x-label for="title" :value="__('common.question')"/>

                                                    <x-input id="title" maxlength="35" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             :value="old('title')" name="title" required autofocus/>
                                                </div>

                                            </div>
                                            <div class="flex w-full mobile-companent">
                                                <div class="w-full mr-3 mt-4 mobile-input">
                                                    <x-label for="date_to" :value="__('common.answer')"/>
                                                    <textarea name="text" class="border border-gray-300 w-full" style="min-height: 300px"></textarea>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-end mt-4">
                                                <p><small></small></p>
                                                <x-button class="ml-3">
                                                    <i class="fas fa-plus"></i> {{ __('common.create') }}
                                                </x-button>
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
