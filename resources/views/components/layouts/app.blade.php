@extends('layouts.base')

@section('body')
@auth
<div class="absolute top-1 right-1 grid">
    <x-button label="admin" :href="route('admin.home')"/>
    <x-button label="logout" :href="route('admin.logout')"/>
    
</div>
@endauth
@if (!env('SMS_API',true))
    <span class="absolute top-2 right-2 z-20">
        <x-badge negative icon="exclamation" nagative label="SMS verlifacition turn off" />
    </span>
@endif
@if(strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)

    <div class="min-h-screen flex flex-col justify-center items-center gap-4">
        <img src="asset('icons/caution.png')"/>
        <x-badge negative lg label="ระบบไม่รองรับการเปิดผ่านไลน์ (Line Application)" />
        <p class="text-blue-600 text-xl">กรุณาเปิดเว็บไซต์ผ่านบราวเซอร์</p>
        <div class="flex">
            <img src="asset('icons/chrome.png')"/>
            <img src="asset('icons/safari.png')"/>
        </div>
        <p class="text-blue-600 text-xl">หรือ สแกนคิวอาร์โค้ดผ่านกล้องปกติ</p>
        <!-- dots-vertical -->
    </div>
@elseif( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false)
{{-- mobile --}}
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2 bg-gray-100">
        <div class="pt-2">
            <a href="/">
                <x-application-logo class="h-20 fill-current text-gray-500" />
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            
            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    </div>
@else
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2 bg-gray-100">
        <div class="pt-2">
            <a href="/">
                <x-application-logo class="h-20 fill-current text-gray-500" />
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    </div>
@endif
@endsection
