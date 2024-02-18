@extends('layouts.email')

@section('content')
    <div class="container m-auto mt-4 mb-10">
        <x-logo class="h-20 m-auto"/>
        <div class="p-4 rounded-xl shadow-lg text-center">
            <h1 class="bg-primary-blue text-white text-2xl font-bold p-4 text-center">
                การลงทะเบียนเสร็จสมบูรณ์
            </h1>
            <img src="{{asset('img/app-banner.png')}}" class="m-auto w-full"/>
            <p class="max-w-sm m-auto text-center my-4">
                หมายเลข <b>{{$client['phone']}}</b><br>
                ลงทะเบียนรับโปรแกรม LOVE Solution Cat Plus<br>
                ปลุกพลัง 3 ชั้น ป้องกันปรสิต<br>
                สำหรับน้องแมว {{$client['pet_name']}}<br>
                สามารถรับสิทธิ์ได้ที่<br>
                <b>{{$client['vet_name']}}</b><br>
                ท่านสามารถโชว์หลักฐาน<br>
                ให้กับพนักงานได้ โดยการคลิก<br>
            </p>
            <x-button lg primary label="รับสิทธิ์" 
            class="m-4 bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl"
            :href="route('client.ticket',['phone'=>$client['phone']])"/>
            <p class="max-w-sm m-auto text-center my-4">
                กรุณากดรับสิทธิ์ขณะอยู่ที่คลินิกหรือ โรงพยาบาลสัตว์<br>
                ที่ลงทะเบียนเท่านั้น<br>
            </p>

        </div>
    </div>
@endsection