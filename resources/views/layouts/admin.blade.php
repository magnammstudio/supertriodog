@extends('layouts.base')

@section('body')
    <div class="flex flex-col justify-center min-h-screen py-2 bg-gray-50 sm:px-4">
        <div class="container m-auto">
            <nav class="flex justify-start items-center flex-wrap gap-2 p-2 ">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
                @can('isAdmin')
                <x-button label="dashboard" icon="template" 
                    :flat="!Str::contains(Route::current()->getName(),'admin.home')" 
                    :primary="Str::contains(Route::current()->getName(),'admin.home')" 
                    
                    href="{{route('admin.home')}}" />
                <x-button flat label="Vet" icon="shopping-cart" 
                    :flat="!Str::contains(Route::current()->getName(),'admin.vets')" 
                    :primary="Str::contains(Route::current()->getName(),'admin.vets')" 
                    
                    href="{{route('admin.vets')}}" />
                @endcan
            
                {{-- <x-select class="py-4 ml-auto w-full sm:w-auto" 
                placeholder="ค้นหาชื่อคลินิก" :options="$vet_list" option-label="name" option-value="id" wire:model="VetSelect" /> --}}
                <div class="ml-auto flex gap-2 items-center">
                    @can('isAdmin')
                    <x-button sm :href="route('client.download')" icon="download" class="rounded-full aspect-square sm:rounded sm:aspect-auto">
                        <span class="hidden sm:inline">download client data</span>
                    </x-button>
                    @endcan
                <x-dropdown>
                    <x-dropdown.item :label="Auth::user()->name"/>
                    <x-slot name="trigger">
                        <x-button.circle icon="user" label="Options" primary />
                    </x-slot>
                    
                    <x-dropdown.item separator label="Logout" icon="logout" :href="route('admin.logout')"/>
                </x-dropdown>
                </div>
            </nav>

        <div class="bg-white rounded-xl p-4 shadow-md min-h-screen">
            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset

        </div>
    </div>
    </div>
@endsection
