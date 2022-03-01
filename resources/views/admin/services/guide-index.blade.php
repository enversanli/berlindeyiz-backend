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
                                            role="alert">
                                            <strong class="font-bold">{{$message['title']}}</strong>
                                            <span class="block sm:inline">{{$message['content']}}</span>
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <h2 style="font-size: 1.5em;" class="mb-6">@lang('common.service_list')</h2>
                                                <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                    <div class="flex items-center justify-end mt-4 mb-4">
{{--                                                    <form action="{{route('user.list')}}" method="get">--}}
{{--                                                        <div class="form-input">--}}
{{--                                                            <input type="text" placeholder="Ara..." name="search"--}}
{{--                                                                   value="{{request()->search}}" autocomplete="search"--}}
{{--                                                                   class="sort-type mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="form-input">--}}
{{--                                                            <select name="sort_type"--}}
{{--                                                                    class="sort-type mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
{{--                                                                <option--}}
{{--                                                                    value="asc" {{request()->sort_type == 'asc' ? 'selected' : ''}}>--}}
{{--                                                                    Artan--}}
{{--                                                                </option>--}}
{{--                                                                <option--}}
{{--                                                                    value="desc" {{request()->sort_type == 'desc' ? 'selected' : ''}}>--}}
{{--                                                                    Azalan--}}
{{--                                                                </option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="form-input">--}}
{{--                                                            <select id="sort_by" name="sort_by" onchange="sortTable()"--}}
{{--                                                                    class="mt-1 block w-full py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
{{--                                                                <option value="full_name">Sırala</option>--}}
{{--                                                                @foreach($columns as $key => $value)--}}
{{--                                                                    <option--}}
{{--                                                                        value="{{$key}}" {{$key == request()->sort_by ? 'selected' : ''}}>{{$value}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
                                                    <x-button class="ml-1 mr-1">
                                                        <a href="{{route('service.create')}}">
                                                            <i class="fas fa-plus"></i> @lang('common.new_service')
                                                        </a>
                                                    </x-button>
                                                </div>
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            @lang('common.title')
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            @lang('common.status')
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            @lang('common.process')
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($guides as $guide)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{$guide->title}}
                                                                        </div>
                                                                        <div class="text-sm text-gray-500">
                                                                            {{\Carbon\Carbon::parse($guide->created_at)->format('d-m-Y H:i:s')}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                                {{$guide->status}}
                                                                        </span>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="px-1 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                <a href="{{route('service.show', $guide->id)}}"
                                                                   class="p-1 pl-3 pr-3 transition-colors duration-50 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-sm rounded-lg focus:border-4 border-indigo-300 mr-5"><i
                                                                        class="fas fa-search"></i> Detay</a>

                                                                    <button type="submit"
                                                                            onclick='modalShow("{{route('service.destroy', $guide->id)}}")'
                                                                            class="p-1  pl-3 pr-3 transition-colors duration-500 transform bg-red-500 hover:bg-red-400 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">
                                                                        <i class="far fa-trash-alt"></i> @lang('common.delete')
                                                                    </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    @if(!$guides->count())
                                                        <tfoot>
                                                        <tr>
                                                            <th colspan="7">

                                                                <div
                                                                    class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative"
                                                                    role="alert">
                                                                    <span
                                                                        class="block sm:inline">@lang('common.no_result')</span>
                                                                </div>

                                                            </th>
                                                        </tr>
                                                        </tfoot>
                                                    @endif
                                                </table>
                                            </div>
                                            <br>
                                            {!! $guides->links() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
