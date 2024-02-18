@extends('layouts.app')

@section('content')
<div class="container m-auto text-center grid items-center h-screen">
    <div>
        <x-logo class="h-20 m-auto"/>
            <h1 class="text-9xl font-bold py-6">403</h1>
            <h2 class="text-xl font-bold py-6">YOU NOT ALLOW HERE</h2>
            @auth
                @if (Auth::user()->isVet())
                    <x-button label="กลับสู่หน้า {{Auth::user()->vet->vet_name}}" :href="route('admin.vet')"/>    
                @else
                    <x-button label="กลับสู่หน้าหลักผู้ดูแล" :href="route('admin.home')"/>    
                @endif
            @else
                <x-button label="กลับสู่หน้าหลัก" :href="route('client.home')"/>
            @endauth
        </div>
    </div>
@endsection