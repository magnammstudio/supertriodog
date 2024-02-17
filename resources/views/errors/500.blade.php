@extends('layouts.app')

@section('content')
<div class="container m-auto text-center grid items-center h-screen">
    <div>
            <h1 class="text-9xl font-bold py-6">500</h1>
            <h2 class="text-xl font-bold py-6">ERROR</h2>
            <x-errors/>
            @auth
                @if (Auth::user()->isVet())
                    <x-button label="กลับสู่หน้าสถานพยาบาล" :href="route('admin.vet')"/>    
                @else
                    <x-button label="กลับสู่หน้าหลักผู้ดูแล" :href="route('admin.home')"/>    
                @endif
            @else
                <x-button label="กลับสู่หน้าหลัก" :href="route('client.home')"/>
            @endauth
        </div>
    </div>
@endsection