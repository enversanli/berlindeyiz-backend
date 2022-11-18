<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('service.index')" :active="request()->routeIs('services')">
        {{ __('common.services') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('service.index')" :active="request()->routeIs('services')">
        {{ __('common.business') }}
    </x-nav-link>
</div>