<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('user.list')" :active="request()->routeIs('user.list')">
        {{ __('common.users') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('service.index')" :active="request()->routeIs('service.index')">
        {{ __('common.services') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('slider.list')" :active="request()->routeIs('slider.list')">
        {{ __('common.sliders') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.index')">
        {{ __('common.faq') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('announcement.index')" :active="request()->routeIs('announcement.index')">
        {{ __('common.announcements') }}
    </x-nav-link>
</div>