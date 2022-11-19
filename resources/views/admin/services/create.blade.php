<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('common.service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{route('service.index')}}"
                       class="border w-40 border-teal-500 text-teal-500 block rounded-sm font-bold py-2 px-3 mr-2 flex items-center hover:bg-black-500 hover:text-gray-500">
                        <svg class="h-5 w-5 mr-2 fill-current" version="1.1" id="Layer_1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" viewBox="-49 141 512 512" style="enable-background:new -49 141 512 512;"
                             xml:space="preserve">
            <path id="XMLID_10_"
                  d="M438,372H36.355l72.822-72.822c9.763-9.763,9.763-25.592,0-35.355c-9.763-9.764-25.593-9.762-35.355,0 l-115.5,115.5C-46.366,384.01-49,390.369-49,397s2.634,12.989,7.322,17.678l115.5,115.5c9.763,9.762,25.593,9.763,35.355,0 c9.763-9.763,9.763-25.592,0-35.355L36.355,422H438c13.808,0,25-11.193,25-25S451.808,372,438,372z"></path>
        </svg>
                        @lang('common.previous_page')
                    </a>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">

                                    @include('admin.components.message')

                                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                                    <form action="{{route('service.store')}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex w-full mobile-companent">
                                            <div class="w-full mr-3 mobile-input">
                                                <x-label for="title" :value="__('common.title')"/>

                                                <x-input id="title" maxlength="55" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="old('title')" name="title" required autofocus/>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="date_from" :value="__('common.date_from')"/>

                                                <x-input id="date_from" maxlength="255"
                                                         class="block mt-1 inputs sm:text-sm w-full "
                                                         type="date" name="date_from" :value="old('date_from')"
                                                         autofocus required/>
                                            </div>

                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="date_to" :value="__('common.date_to')"/>

                                                <x-input id="date_to" maxlength="255"
                                                         class="block mt-1 inputs sm:text-sm w-full"
                                                         type="date" name="date_to" :value="old('date_to')"
                                                         autofocus/>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="start_time" :value="__('common.start_time')"/>
                                                <x-input id="start_time" maxlength="255"
                                                         class="block mt-1 inputs sm:text-sm w-full inline-block float-left"
                                                         type="time" name="start_time" :value="old('start_time')"
                                                         autofocus/>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="end_time" :value="__('common.end_time')"/>
                                                <x-input id="end_time" maxlength="255"
                                                         class="block mt-1 inputs sm:text-sm w-full inline-block float-left"
                                                         type="time" name="end_time" :value="old('end_time')"
                                                         autofocus/>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent mt-10 border-2 p-3">
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="city" :value="__('service.city')"/>
                                                <select id="city" name="city_id"
                                                        class="w-full rounded border-gray-300">
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="district" :value="__('service.district')"/>
                                                <select id="district" name="district_id"
                                                        class="w-full rounded border-gray-300">
                                                    @foreach($districts as $district)
                                                        <option value="{{$district->id}}">{{$district->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-1/2 mr-3  mobile-input mx-1">
                                                <x-label for="address" :value="__('service.address')"/>
                                                <textarea name="address" class="border border-gray-300 w-full"
                                                          style="height:40px;min-height: 40px; max-height: 80px"></textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-1/4 mr-3  mobile-input mx-auto">
                                                <x-label for="is_priced" :value="__('service.is_priced')"/>
                                                <select name="is_priced" class="rounded border-gray-300 w-full">
                                                    <option value="0" selected>@lang('common.no')</option>
                                                    <option value="1">@lang('common.yes')</option>
                                                </select>
                                            </div>
                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="price" :value="__('service.price')"/>
                                                <x-input id="price" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="old('price')" name="price" required autofocus/>
                                            </div>
                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="category_id" :value="__('service.category')"/>
                                                <select name="category_id" class="w-full rounded border-gray-300">
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent">
                                            <div class="w-full mr-3 mt-4 mobile-input">
                                                <x-label for="date_to" :value="__('service.details')"/>
                                                <textarea style="margin-top: 50px;" name="text" id="editor">

                                                    </textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-full h-50">
                                                <h3 class="mb-3">Harita</h3>
                                                <textarea name="meta[map]" class="w-full h-50 border border-b-0"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-span-12 sm:col-span-12 lg:col-span-12 mt-70 mt-10">
                                            <label for="image"
                                                   class="block text-sm font-medium text-gray-700">@lang('service.image')</label>
                                            <input type="file" accept="image/x-png,image/gif,image/jpeg"
                                                   name="logo" id="image"
                                                   class="mt-1 focus:ring-indigo-500 inputs focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
<script>
    CKEDITOR.replace('editor');

    $('#city').change(function () {
        var cidy_id = $('#city').val();
        $.ajax({
            url: '/cities/' + cidy_id + '/districts',
            cache: true,
            success: function (response) {
                $('#district').find('option').remove();

                for (x = 0; x < response.data.length; x++) {
                    var row = response.data[x];

                    $('#district').append("<option value=''>" + row.name + "</option>");
                }
            }
        });
    });
</script>