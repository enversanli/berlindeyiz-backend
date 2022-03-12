
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('common.users') }}
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
                                    <div class="flex flex-col">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <h2 style="font-size: 1.5em;" class="mb-6">@lang('service.service_list')</h2>
                                                <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                    <div class="flex items-center justify-end mt-4 mb-4">

                                                    <x-button class="ml-1 mr-1">
                                                        <a href="{{route('service.create')}}">
                                                            <i class="fas fa-plus"></i> @lang('service.new_service')
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

                                                    @foreach($data->data as $user)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{$user->first_name}} {{$user->last_name}}
                                                                        </div>
                                                                        <div class="text-sm text-gray-500">
                                                                            {{\Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s')}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="">
                                                                        <div class="text-sm font-medium text-gray-900">

                                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                {{$user->status}}
                                                                            </span>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="px-1 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                <a href="{{route('admin.user.show', $user->id)}}"
                                                                   class="p-1 pl-3 pr-3 transition-colors duration-50 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-sm rounded-lg focus:border-4 border-indigo-300 mr-5"><i
                                                                        class="fas fa-search"></i> Detay</a>

                                                                    <button type="submit"
                                                                            onclick='modalShow("{{route('admin.user.destroy', $user->id)}}")'
                                                                            class="p-1  pl-3 pr-3 transition-colors duration-500 transform bg-red-500 hover:bg-red-400 text-gray-100 text-sm rounded-lg focus:border-4 border-red-300">
                                                                        <i class="far fa-trash-alt"></i> @lang('common.delete')
                                                                    </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    @if(!$data->data->count())
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
                                            {!! $data->data->links() !!}
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
