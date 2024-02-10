@extends('layouts.base')

@section('body')
@auth
<div class="absolute top-1 right-1 grid">
    <x-button label="admin" :href="route('admin.home')"/>
    <x-button label="logout" :href="route('admin.logout')"/>
    
</div>
@endauth
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2 bg-gray-100">
    <div class="pt-2">
        <a href="/">
            <x-application-logo class="h-20 fill-current text-gray-500" />
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        @if (!env('SMS_API',true))
            <span class="absolute top-2 right-2">
                <x-badge negative icon="exclamation" nagative label="SMS verlifacition turn off" />
            </span>
            
        @endif
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
</div>
@endsection
