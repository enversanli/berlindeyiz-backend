

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
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">

                                    @include('admin.components.message')

                                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                                    <form action="{{route('service.update', $service->id)}}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex w-full mobile-companent">
                                            <div class="w-3/4 mobile-input px-2">
                                                <x-label for="title" :value="__('common.title')"/>

                                                <x-input id="title" maxlength="55" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="$service->title" name="title" required autofocus/>
                                            </div>
                                            <div class="w-1/4 mobile-input">
                                                <select name="approved" class="rounded border-gray-300 w-full mt-4">
                                                    <option value="0" {{$service->approved == 0 ?'selected' : ''}}>@lang('user.waiting_approval')</option>
                                                    <option value="1" {{$service->approved == 1 ?'selected' : ''}}>@lang('user.approved')</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="date_from" :value="'Durum'"/>

                                                <select id="status" name="status"
                                                        class="w-full rounded border-gray-300">
                                                    <option value="ACTIVE" {{$service->status == 'ACTIVE' ?'selected' : ''}}>Aktif</option>
                                                    <option value="SPONSORED" {{$service->status == 'SPONSORED' ?'selected' : ''}}>Sponsorlu</option>
                                                    <option value="CANCELED" {{$service->status == 'CANCELED' ?'selected' : ''}}>İptal Edildi</option>
                                                    <option value="OUT_OF_DATE" {{$service->status == 'OUT_OF_DATE' ?'selected' : ''}}>Sone Erdi</option>
                                                </select>
                                            </div>

                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="date_from" :value="'Bilet Satış veya Rezervasyon'"/>

                                                <select id="internal_ticket" name="internal_ticket"
                                                        class="w-full rounded border-gray-300">
                                                    <option value="0" {{$service->internal_ticket == 0 ?'selected' : ''}}>Hayır</option>
                                                    <option value="1" {{$service->internal_ticket == 1 ?'selected' : ''}}>Evet</option>
                                                </select>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="show_price" :value="'Bilet Fiyatı Görünsün'"/>

                                                <select id="show_price" name="show_price"
                                                        class="w-full rounded border-gray-300">
                                                    <option value="0" {{$service->show_price == 0 ?'selected' : ''}}>Hayır</option>
                                                    <option value="1" {{$service->show_price == 1 ?'selected' : ''}}>Evet</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-1/3 mr-3  mobile-input mx-1">
                                                <x-label for="date_from" :value="__('common.date_from')"/>

                                                <x-input id="date_from" maxlength="255"
                                                         class="block mt-1 w-full inputs sm:text-sm"
                                                         type="date" name="date_from" :value="$service->date_from"
                                                         autofocus required/>
                                            </div>
                                            <div class="w-1/3 mr-3  mobile-input mx-1">
                                                <x-label for="date_to" :value="__('common.date_to')"/>

                                                <x-input id="date_to" maxlength="255"
                                                         class="block mt-1 w-full inputs sm:text-sm"
                                                         type="date" name="date_to" :value="$service->date_to"

                                                         autofocus/>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="start_time" :value="__('common.start_time')"/>
                                                <x-input id="start_time" maxlength="255"
                                                         class="block mt-1 inputs sm:text-sm w-full inline-block float-left"
                                                         type="time" name="start_time" :value="$service->start_time"
                                                         autofocus required/>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="end_time" :value="__('common.end_time')"/>
                                                <x-input id="end_time" maxlength="255"
                                                         class="block mt-1 inputs sm:text-sm w-full inline-block float-left"
                                                         type="time" name="end_time" :value="$service->end_time"
                                                         autofocus/>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent mt-10 border-2 p-3">
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="city" :value="__('service.city')"/>
                                                <select id="city" name="city_id"
                                                        class="w-full rounded border-gray-300">
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" {{$city->id == $service->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-1/4 mr-3  mobile-input mx-1">
                                                <x-label for="district" :value="__('service.district')"/>
                                                <select id="district" name="district_id"
                                                        class="w-full rounded border-gray-300">
                                                    @foreach($districts as $district)
                                                        <option value="{{$district->id}}" {{$district->id == $service->district_id ?'selected' : ''}}>{{$district->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-1/2 mr-3  mobile-input mx-1">
                                                <x-label for="address" :value="__('service.address')"/>
                                                <textarea name="address" class="border border-gray-300 w-full"
                                                          style="height:40px;min-height: 40px; max-height: 80px">{{$service->address}}</textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-1/4 mr-3  mobile-input mx-auto">
                                                <x-label for="is_priced" :value="__('service.is_priced')"/>
                                                <select name="is_priced" class="rounded border-gray-300 w-full">
                                                    <option value="0" {{$service->is_priced == 0 ?'selected' : ''}}>@lang('common.no')</option>
                                                    <option value="1" {{$service->is_priced == 1 ?'selected' : ''}}>@lang('common.yes')</option>
                                                </select>
                                            </div>

                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="price" :value="__('service.price')"/>
                                                <x-input id="price" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         placeholder="0"
                                                         :value="$service->price" name="price" required autofocus/>
                                            </div>

                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="type" :value="__('service.category')"/>
                                                <select id="type" name="type_id"
                                                        class="w-full rounded border-gray-300" >
                                                    <option value="1" {{$service->type->id == 1 ? 'selected' : ''}}>Etkinlik</option>
                                                    <option value="2" {{$service->type->id == 2 ? 'selected' : ''}}>Doktor</option>
                                                    <option value="3" {{$service->type->id == 3 ? 'selected' : ''}}>Avukat</option>
                                                </select>
                                            </div>

                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="category_id" :value="__('service.category')"/>
                                                <select name="category_id" class="w-full rounded border-gray-300" id="category">
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" {{$service->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="phone" :value="__('service.phone')"/>
                                                <x-input id="phone" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="$service->meta['phone'] ?? ''" name="meta[phone]" />
                                            </div>

                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="mail" :value="__('service.mail')"/>
                                                <x-input id="mail" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="$service->meta['mail'] ?? ''" name="meta[mail]"/>
                                            </div>

                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="website" :value="__('service.website')"/>
                                                <x-input id="website" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="$service->meta['website'] ?? ''" name="meta[website]"/>
                                            </div>

                                            <div class="w-1/4 mr-3 mobile-input mx-auto">
                                                <x-label for="ticket" :value="__('service.ticket_url')"/>
                                                <x-input id="ticket" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="$service->meta['ticket'] ?? ''" name="meta[ticket]"/>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent">
                                            <div class="w-full mr-3 mt-4 mobile-input">
                                                <x-label for="date_to" :value="__('common.description')"/>
                                                <textarea style="margin-top: 50px;" name="text" id="editor">
                                                {{$service->text}}
                                                    </textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-full h-50">
                                                <h3 class="mb-3">Harita</h3>
                                                <textarea name="meta[map]" class="w-full h-50 border border-b-0">{{$service->meta['map'] ?? ''}}</textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10 border-2 p-3">
                                            <div class="w-full lg:w-1/2 md:w-1/2 sm:w-full h-50">
                                                <h3 class="mb-3">SEO Açıklaması</h3>
                                                <textarea name="meta[seo_description]" class="w-full h-50 border border-b-0">{{$service->meta['seo_description'] ?? ''}}</textarea>
                                            </div>
                                            <div class="w-full lg:w-1/2 md:w-1/2 sm:w-full h-50 px-2">
                                                <h3 class="mb-3">Anahtar Kelimeler</h3>
                                                <textarea name="meta[keywords]" class="w-full h-50 border border-b-0">{{$service->meta['keywords'] ?? ''}}</textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent">
                                            <div class="w-1/2 mr-3 mt-4 mobile-input">
                                                <label for="logo"
                                                       class="block text-sm font-medium text-gray-700">@lang('service.current_image')</label>
                                                <div class="p-3"><img style="width: 200px"
                                                                      src="/storage/{{$service->logo}}">
                                                </div>

                                            </div>



                                            <div class="w-1/2 mt-4 customer_number mobile-input">
                                                <label for="logo"
                                                       class="block text-sm font-medium text-gray-700">@lang('service.new_image')</label>
                                                <input type="file" accept="image/x-png,image/gif,image/jpeg,image/webp"
                                                       name="logo" id="image"
                                                       class="mt-3 focus:ring-indigo-500 inputs focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="col-span-6 sm:col-span-12 lg:col-span-12 mt-70">

                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <p><small></small></p>
                                            <x-button class="ml-3">
                                                <i class="fas fa-plus"></i> {{ __('common.update') }}
                                            </x-button>
                                            <a href="{{route('service.questions', $service->id)}}" class="ml-3">
                                                <i class="fas fa-plus"></i> {{ __('service.faq') }}
                                            </a>
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
            url: '/cities/'+cidy_id+'/districts',
            cache:true,
            success: function (response) {
                $('#district').find('option').remove();

                for (x = 0; x < response.data.length; x++){
                    var row = response.data[x];

                    $('#district').append("<option value=''>"+row.name+"</option>");
                }
            }
        });
    });

    $('#type').change(function () {
        var serviceTypeId = $('#type').val();
        $.ajax({
            url: '/admin/service-categories/' + serviceTypeId,
            cache: true,
            success: function (response) {
                $('#category').find('option').remove();

                for (x = 0; x < response.data.length; x++) {
                    var row = response.data[x];

                    $('#category').append("<option value=" + row.id + ">" + row.name + "</option>");
                }
            }
        });
    });
</script>