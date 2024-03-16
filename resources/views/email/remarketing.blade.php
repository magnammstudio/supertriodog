@extends('layouts.email')

@section('content')
    <div class="container m-auto mt-4 mb-10">
        <x-logo class="h-20 m-auto"/>
        <div class="p-4 rounded-xl shadow-lg text-center">
            <h1 class="bg-primary-blue text-white text-2xl font-bold pt-4 text-center">
                {{env('APP_NAME')}}
            </h1>
            <div class="bg-primary-blue text-white font-bold pb-2 text-center">
                {{env('APP_TAGLINE')}}
            </div>
            
            <img src="{{asset('img/app-banner.png')}}" class="m-auto w-full"/>
            <p class="max-w-sm m-auto text-center my-4">
                หมายเลข <b>{{$client->phone}}</b><br>
                {{$status}}<hr>
                
                สามารถรับสิทธิ์ได้ที่<br>
                <b>{{$client->vet->vet_name}}</b><br>
                ท่านสามารถโชว์หลักฐาน<br>
                ให้กับพนักงานได้ โดยการคลิก<br>
            </p>
            <x-button lg primary label="รับสิทธิ์" 
            class="m-4 bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl"
            :href="route('client.rmkt',['phone'=>$client->phone])"/>
            <p class="max-w-sm m-auto text-center my-4">
                กรุณากดรับสิทธิ์ขณะอยู่ที่คลินิกหรือ โรงพยาบาลสัตว์<br>
                ที่ลงทะเบียนเท่านั้น<br>
            </p>

        </div>
    </div>
@endsection