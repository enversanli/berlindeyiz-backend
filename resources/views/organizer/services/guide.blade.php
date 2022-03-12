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
                    <a href="{{request()->headers->get('referer')}}"
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
                                    <form action="{{$guideRoute}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex w-full mobile-companent">
                                            <div class="w-1/2 mr-3 mobile-input">
                                                <x-label for="title" :value="__('common.title')"/>

                                                <x-input id="title" maxlength="35" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         value="{{isset($service->guide)?$service->guide->title : ''}}"
                                                         name="title" required autofocus/>
                                            </div>
                                            <div class="w-1/2 mobile-input">
                                                <x-label for="youtube_url" :value="__('common.youtube_url')"/>

                                                <x-input id="url" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         value="{{isset($service->guide)?$service->guide->youtube_url : ''}}"
                                                         name="youtube_url" required autofocus/>
                                            </div>
                                        </div>
                                        <div class="flex w-full mobile-companent mt-10">
                                            <div class="w-1/2 mr-3 mobile-input">
                                                <x-label for="get_in_url" :value="__('common.get_in_url')"/>

                                                <x-input id="get_in_url" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         value="{{isset($service->guide)?$service->guide->get_in_url : ''}}"
                                                         name="get_in_url" autofocus/>
                                            </div>
                                        </div>
                                        <!-- Password -->
                                        <div class="w-full mt-10">

                                           <textarea style="margin-top: 50px" name="text" id="editor">
                                    {{isset($service->guide)?$service->guide->text : ''}}
                                </textarea>
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <p><small></small></p>
                                            <x-button class="ml-3">
                                                <i class="fas fa-plus"></i> {{ __('common.setGuide') }}
                                            </x-button>
                                        </div>
                                    </form>

                                    @if($service->guide)
                                        <form method="POST" action="{{route('service.hardware', $service->id)}}">
                                            @csrf
                                            <div class="flex w-full mobile-companent">
                                                <div class="w-1/2 mr-3 mobile-input">
                                                    <x-label for="cpu" :value="__('common.cpu')"/>

                                                    <x-input id="cpu" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{isset($service->systemRequirement)?$service->systemRequirement->cpu : ''}}"
                                                             name="cpu" autofocus/>
                                                </div>
                                                <div class="w-1/2 mobile-input">
                                                    <x-label for="ram" :value="__('common.ram')"/>

                                                    <x-input id="url" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{isset($service->systemRequirement)?$service->systemRequirement->ram : ''}}"
                                                             name="ram" autofocus/>
                                                </div>
                                            </div>

                                            <div class="flex w-full mobile-companent mt-5">
                                                <div class="w-1/2 mr-3 mobile-input">
                                                    <x-label for="network" :value="__('common.network')"/>

                                                    <x-input id="network" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{isset($service->systemRequirement)?$service->systemRequirement->network : ''}}"
                                                             name="network" autofocus/>
                                                </div>
                                                <div class="w-1/2 mobile-input">
                                                    <x-label for="storage" :value="__('common.storage')"/>

                                                    <x-input id="storage" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{isset($service->systemRequirement)?$service->systemRequirement->storage : ''}}"
                                                             name="storage" autofocus/>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-end mt-4">
                                                <p><small></small></p>
                                                <x-button class="ml-3">
                                                    <i class="fas fa-plus"></i> {{ __('common.setHardware') }}
                                                </x-button>
                                            </div>
                                        </form>

                                        <form method="POST"
                                              action="{{route('service-guide-social.update', [$service->id, $service->guide->id])}}">
                                            @csrf
                                            <div class="flex w-full mobile-companent">
                                                <div class="w-1/2 mr-3 mobile-input">
                                                    <x-label for="telegram" :value="__('common.telegram')"/>

                                                    <x-input id="telegram" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{$service->guide->telegram}}"
                                                             name="telegram" autofocus/>
                                                </div>
                                                <div class="w-1/2 mobile-input">
                                                    <x-label for="twitter" :value="__('common.twitter')"/>

                                                    <x-input id="url" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{$service->guide->twitter}}"
                                                             name="twitter" autofocus/>
                                                </div>
                                            </div>

                                            <div class="flex w-full mobile-companent mt-5">
                                                <div class="w-1/2 mr-3 mobile-input">
                                                    <x-label for="facebook" :value="__('common.facebook')"/>

                                                    <x-input id="facebook" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{$service->guide->facebook}}"
                                                             name="facebook" autofocus/>
                                                </div>
                                                <div class="w-1/2 mobile-input">
                                                    <x-label for="website" :value="__('common.website')"/>

                                                    <x-input id="website" maxlength="255" minlength="1"
                                                             class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                             value="{{$service->guide->website}}"
                                                             name="website" autofocus/>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-end mt-4">
                                                <p><small></small></p>
                                                <x-button class="ml-3">
                                                    <i class="fas fa-plus"></i> {{ __('common.setSocial') }}
                                                </x-button>
                                            </div>
                                        </form>
                                    @endif
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
    CKEDITOR.replace( 'editor' );
</script>

