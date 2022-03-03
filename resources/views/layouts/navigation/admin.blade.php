<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('slider.list')" :active="request()->routeIs('slider.list')">
        {{ __('common.sliders') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('faq')" :active="request()->routeIs('faq')">
        {{ __('common.faq') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('announcement.list')" :active="request()->routeIs('announcement.list')">
        {{ __('common.announcements') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('validator.list')" :active="request()->routeIs('validator.list')">
        {{ __('common.validators') }}
    </x-nav-link>
</div>