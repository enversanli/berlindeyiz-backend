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
                    Hoş geldin, <br><b>{{auth()->user()->first_name}}</b>
                    {{--                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
                    {{--                        <div class="p-6 bg-white border-b border-gray-200" id="counter">--}}
                    {{--                            <div class="dashboard-list">--}}
                    {{--                                <div class="list-title">Toplam Müşteri </div>--}}
                    {{--                                <div class="list-content counter-val"><span data-count="4">4</span></div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="dashboard-list">--}}
                    {{--                                <div class="list-title">Toplam Sipariş </div>--}}
                    {{--                                <div class="list-content counter-val"><span data-count="3">3</span></div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="dashboard-list">--}}
                    {{--                                <div class="list-title">Toplam Ürün</div>--}}
                    {{--                                <div class="list-content counter-val"><span data-count="4">4</span></div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
            <link rel="stylesheet"
                  href="https://cdn.jsdelivr.net/gh/Loopple/loopple-public-assets@main/riva-dashboard-tailwind/riva-dashboard.css">
            <div class="flex flex-wrap -mx-3 mb-5">
                <div class="w-full max-w-full px-3 mb-6  mx-auto">
                    <div class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
                        <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
                            <!-- card header -->
                            <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                                <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
                                    <span class="mr-3 font-semibold text-dark">Bilet Rezervasyonları</span>
                                    <span class="mt-1 font-medium text-secondary-dark text-lg/normal">Konser veya Etkinliklere dair rezervasyonlar burada listelenir</span>
                                </h3>
                                <div class="relative flex flex-wrap items-center my-2">
                                    <a href="javascript:void(0)"
                                       class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-light focus:bg-light">
                                        Etkinlikleri Görüntüle </a>
                                </div>
                            </div>
                            <!-- end card header -->
                            <!-- card body  -->
                            <div class="flex-auto block py-8 pt-6 px-9">
                                <div class="overflow-x-auto">
                                    <table class="w-full my-0 align-middle text-dark border-neutral-200">
                                        <thead class="align-bottom">
                                        <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                                            <th class="pb-3 text-start min-w-[175px]">Etkinlik</th>
                                            <th class="pb-3 text-end min-w-[100px]">Adı</th>
                                            <th class="pb-3 text-end min-w-[100px]">Soyadı</th>

                                            <th class="pb-3 pr-12 text-end min-w-[175px]">Mail Adresi</th>
                                            <th class="pb-3 pr-12 text-end min-w-[175px]">Telefon Numarası</th>
                                            <th class="pb-3 pr-12 text-end min-w-[175px]">Durum</th>
                                            <th class="pb-3 pr-12 text-end min-w-[100px]">Tarih</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tickets as $ticket)
                                            <tr class="border-b border-dashed last:border-b-0">
                                                <td class="p-3 pl-0">
                                                    <div class="flex items-center">
                                                        <div class="relative inline-block shrink-0 rounded-2xl me-3">
                                                            <img src="https://raw.githubusercontent.com/Loopple/loopple-public-assets/main/riva-dashboard-tailwind/img/img-49-new.jpg"
                                                                 class="w-[50px] h-[50px] inline-block shrink-0 rounded-2xl"
                                                                 alt="">
                                                        </div>
                                                        <div class="flex flex-col justify-start">
                                                            <a href="javascript:void(0)"
                                                               class="mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary">
                                                                {{$ticket->service->title}} </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="p-3 pr-0 text-end">
                                                    <span class="font-semibold text-light-inverse text-md/normal">{{$ticket->first_name}}</span>
                                                </td>
                                                <td class="p-3 pr-0 text-end">
                                                    <span class="font-semibold text-light-inverse text-md/normal">{{$ticket->last_name}}</span>
                                                </td>
                                                <td class="p-3 pr-0 text-end">
                                                    <span class="font-semibold text-light-inverse text-md/normal">{{$ticket->email}}</span>
                                                </td>
                                                <td class="p-3 pr-0 text-end">
                                                    <span class="font-semibold text-light-inverse text-md/normal">{{$ticket->phone}}</span>
                                                </td>
                                                <td class="p-3 pr-12 text-end">
                                                    <span class="text-center align-baseline inline-flex px-4 py-3 mr-auto items-center font-semibold text-[.95rem] leading-none text-primary bg-primary-light rounded-lg"> {{$ticket->status}} </span>
                                                </td>
                                                <td class="pr-0 text-start">
                                                    <span class="font-semibold text-light-inverse text-md/normal">{{$ticket->created_at}}</span>
                                                </td>

                                                <!--
                                                <td class="p-3 pr-0 text-end">
                                                    <button class="ml-auto relative text-secondary-dark bg-light-dark hover:text-primary flex items-center h-[25px] w-[25px] text-base font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-200 ease-in-out shadow-none border-0 justify-center">
              <span class="flex items-center justify-center p-0 m-0 leading-none shrink-0 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
              </span>
                                                    </button>
                                                </td>
                                                -->
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-5">
                <div class="w-full max-w-full sm:w-3/4 mx-auto text-center">
                    <p class="text-sm text-slate-500 py-1">
                        by <a href="https://www.tulparcreative.de" class="text-slate-700 hover:text-slate-900"
                              target="_blank">Tulpar Creative</a>. </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
