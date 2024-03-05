@extends('layouts.base')

@section('body')

    <x-notifications />
    <div class="flex flex-col justify-center min-h-screen py-2 bg-gray-50 sm:px-4">
        <div class="container m-auto">
            <nav class="flex justify-start items-center flex-wrap gap-2 p-2 ">
                <x-logo class="block h-10 w-auto fill-current text-gray-800" />
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
                @can('isMaster')

                    <x-button label="MA" icon="template" 
                        :flat="!Str::contains(Route::current()->getName(),'ma.vet')" 
                        :primary="Str::contains(Route::current()->getName(),'ma.vet')" 
                        :href="route('ma.vet')" />

                    <x-button label="Client" icon="template" 
                    :flat="!Str::contains(Route::current()->getName(),'admin.client')" 
                    :primary="Str::contains(Route::current()->getName(),'admin.client')" 
                    :href="route('admin.client.index')" />

                    <x-button label="MA" icon="template" 
                        :flat="!Str::contains(Route::current()->getName(),'ma.vet')" 
                        :primary="Str::contains(Route::current()->getName(),'ma.vet')" 
                        :href="route('ma.vet')" />
                    
                    {{-- <x-button label="Register" :href="route('admin.register')"/> --}}
                    {{-- <x-button label="edit" :href="route('admin.edit',Auth::user())"/> --}}
                            
                @endcan
            
                <div class="ml-auto flex gap-2 items-center">
                    @can('isAdmin')
                    <x-button sm :href="route('client.download')" icon="download" class="rounded-full aspect-square sm:rounded sm:aspect-auto">
                        <span class="hidden sm:inline">download client data</span>
                    </x-button>
                    @endcan
                        <x-dropdown width="w-max">
                            <x-slot name="trigger">
                                <x-button.circle icon="user" label="Options" primary />
                            </x-slot>
                            @if (Auth::user()->vet)
                                @foreach ( Auth::user()->vet->stock->vet()->get() as $key => $vet )
                                    <x-dropdown.item :separator="$key!=0" :label="$vet->vet_name" :href="route('admin.vet',$vet->id)"/>
                                @endforeach
                            @else
                                <x-dropdown.item :label="Auth::user()->name" />
                            @endif
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
