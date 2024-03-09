<div>
    @if (env('APP_DEBUG'))
        @if (env('RMKT_GAME',false))
            <x-badge label="game mode"/>
        @else
            <x-badge label="no game mode"/>
        @endif
    @endif
    @isset($currentStep)
        @switch($currentStep)
            @case(-1)
                {{-- start here by defult --}}
                {{-- option regis or try again --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    <div class="mt-8 pb-2">
                        <p class="mb-4 text-center">
                            เข้าสู่ระบบสิทธิพิเศษ<br>
                            เข้าโปรแกรม {{env('APP_NAME','-')}}<br>
                            {{env('APP_TAGLINE')}}
                        </p>
                        <img class="my-8 px-8" src="{{ asset('img/app-banner.png') }}" />
                    </div>
                    <div class="py-2 text-center mt-auto " wire:loading.remove>

                        <x-button lg primary right-icon="chevron-right" 
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl m-2" 
                            wire:click="step" label="เคยลงทะเบียน" />

                        <x-button lg primary right-icon="chevron-right" 
                            class="rounded-2xl m-2" 
                            wire:click="registerNew" label="ยังไม่เคยลงทะเบียน" />

                        {{-- ตรวจสอบสิทธิ์ --}}

                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>

                </div>
            @break

            @case(0)
                {{-- step (0) phone input --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    {{-- phone number input --}}
                    <div class="mt-8 pb-2">
                        <p class="mb-4">
                            กรุณากรอกหมายเลขโทรศัพท์ ที่ท่านเคยลง ทะเบียนรับสิทธิ์
                            เข้าโปรแกรม {{env('APP_NAME')}}<br>
                            {{env('APP_TAGLINE')}}
                        </p>
                        <x-errors/>
                        <x-input label="หมายเลขโทรศัพท์" maxlength="10" minlength="10" placeholder="หมายเลขโทรศัพท์"
                            pattern="[0-9]*" inputmode="tel" required wire:model.defer="data.phone" />
                    </div>
                    <img class="my-4 px-8" src="{{ asset('img/app-banner.png') }}" />
                    <div class="py-2 text-center mt-auto " wire:loading.remove>

                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl" 
                            wire:click="verifyPhoneNumber" label="ตรวจสอบสิทธิ์" />
                        {{-- ตรวจสอบสิทธิ์ --}}

                        @error('data.phone')
                        <x-button lg right-icon="chevron-right" primary
                            class="rounded-2xl"
                            wire:click="registerNew" 
                            type="button" label="ลงทะเบียนลูกค้าใหม่"/>
                        @enderror

                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                </div>
            @break

            @case(1)
                {{-- request otp and verify otp --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    <div class="mt-8 pb-2">
                        <h3 class="text-center text-xl pb-2 font-bold"> ยืนยัน OTP </h3>
                        <p class="text-center"> 
                            เราได้ส่ง SMS ไปยังหมายเลข {{ $data['phone'] ?? '-' }}

                            @isset($data['refno'])
                                <br>Ref. {{$data['refno']??''}}
                            @endisset
                        </p>

                    </div>
                    <div class="single-input-container flex gap-2 my-8">
                        <x-input wire:model.defer="data.pin" type="text" maxlength="6" inputmode="numeric" 
                            class=" text-center focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" />
                    </div>
                    <div class="py-2 text-center mt-auto" wire:loading.remove>
                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="validateOTP" type="button" label="ถัดไป" />
                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                </div>
            @break

            @case(2)
                {{-- magic link --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    {{-- confirm data and privage --}}
                    <div class="mt-8 pb-2">
                        <h3 class="text-xl pb-2 font-bold"> ถึงเวลา {{ $client_data->pet_name ?? '' }} </h3>

                        เข้าโปรแกรม {{env('APP_NAME')}}<br>
                        {{env('APP_TAGLINE')}}<br>
                        เป็นประจำทุกเดือนแล้ว<br>

                    </div>
                    <span class="text-sm">
                        *กรุณากดรับสิทธิพิเศษ เมื่อถึงคลินิกหรือโรงพยาบาลสัตว์ที่ต้องการเข้าร่วมโปรแกรม
                    </span>
                    <img class="my-4 px-8" src="{{ url('/app-banner.png') }}" />
                    <div class="py-2 text-center mt-auto grid gap-2" wire:loading.remove>
                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="next(3)" type="button" label="รับสิทธิ์" />
                        <x-button lg {{-- right-icon="chevron-right"  --}} primary
                            class="bg-gradient-to-br from-warning-600 to-negative-600 rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="next(6)" type="button" label="เก็บสิทธิ์ไว้ก่อน" />
                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                    {{-- show opt out button case from rmkt --}}
                </div>
            @break

            @case(3)
                {{-- check info --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    {{-- opt in --}}
                    <div class="mt-8 pb-2">
                        <h3 class="text-center text-xl pb-2 font-bold">กรุณาตรวจสอบข้อมูลเพื่อยืนยันรับสิทธิ์</h3>

                        <ul>
                            <li>ชื่อแมว : {{ $client->pet_name ?? '' }}</li>
                            <li>น้ำหนัก : {{ $client->pet_weight ?? '' }}</li>
                            <li>อายุ : {{ $client->pet_age_year ?? '' }} ปี {{ $client->pet_age_month ?? '' }} เดือน</li>
                            <li>คลินิกหรือโรงพยาบาลสัตว์ : {{ $client->vet->vet_name ?? '' }}</li>
                            @isset($chooseMonth)
                            <hr>
                                <li>เข้าโปรแกรม {{ $chooseMonth }} เดือน</li>
                            @endisset
                            
                        </ul>

                    </div>
                    <div class="flex justify-between py-2 text-center mt-auto" wire:loading.remove>
                        <x-button lg {{-- right-icon="chevron-right"  --}} primary
                            class="bg-gradient-to-br  from-warning-600 to-negative-600 rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="changeVet" type="button" label="เปลี่ยนสถานที่รับสิทธิ์" />
                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="savermktdata" type="button" label="ยืนยัน" />
                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                    {{-- edit or confirm --}}
                </div>
            @break

            @case(4)
                {{-- select vet --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">

                    <div class="mt-8 pb-2">
                        <h3 class="text-center text-xl pb-2 font-bold">กรุณาเลือกสถานพยาบาลที่เข้ารับบริการ</h3>
                    </div>


                        
                        @if ($vet_list['province']!=null)
                            <div class="mt-4" >
                                <x-select
                                    label="จังหวัด" placeholder="เลือกจังหวัด"
                                    wire:model.live="selected_vet.province"
                                    :options="$vet_list['province']"
                                    clearable=false/>
                            </div>
                        @endif

                        @if ($selected_vet['province']!=null)
                        <div class="mt-4">
                            <x-native-select 
                                label="อำเภอ" placeholder="เลือกอำเภอ" 
                                wire:model.live="selected_vet.district" 
                                :options="$vet_list['city']" /> 
                        </div>
                        @endif

                        @if ($selected_vet['district']!=null)
                        <div class="mt-4">
                            <x-native-select 
                                label="ตำบล" placeholder="เลือกตำบล" 
                                wire:model.live="selected_vet.tambon" 
                                :options="$vet_list['area']" />
                        </div>
                        @endif


                        @if($selected_vet['id']==null)
                        <div class="mt-4 bg-[#E9EFF6] rounded-xl p-2 h-[25vh] overflow-y-scroll soft-scrollbar">
                            @foreach ( $vet_list['name'] as $id => $name )
                            <div class="mb-4">
                                <x-radio id="{{$id}}" label="{{$id}} {{$name}}" value="{{$id}}" 
                                wire:model.lazy="selected_vet.id" />
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="mt-4">
                            {{$selected_vet['name']}}<br>
                            <p>
                            {{$selected_vet['address']}}<br>
                            </p>
                        </div>
                        @endif

        
                    <div class="flex justify-between py-2 text-center mt-auto" wire:loading.remove>
                        <x-button lg primary
                            class="bg-gradient-to-br  from-warning-600 to-negative-600 rounded-2xl"
                            wire:click="step(3)" type="button" label="ยกเลิก" />

                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl"
                            wire:click="updateVet" type="button" label="ยืนยัน" />
                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                </div>
            @break

            @case(5)
                {{-- timed notis --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    <div class="text-center my-8 p-4 rounded-3xl text-white bg-primary-blue">
                        <p class="my-4 leading-relaxed text-2xl">
                            รหัสจะมีอายุ 15 นาที <br>
                            ท่านจะสามารถใช้งานได้<br>
                        </p>
                        <p class="my-4 leading-relaxed text-2xl">
                            กรุณากดรับสิทธิ์ขณะอยู่ที่คลินิก<br>
                            หรือ โรงพยาบาลสัตว์<br>
                            ที่ลงทะเบียนเท่านั้น
                        </p>
                        <p class="my-4 leading-relaxed text-2xl">
                            มิฉะนั้น รหัส<br>
                            จะไม่สามารถใช้งานได้ <br>
                            หากมีข้อสงสัย ติดต่อ <br>
                        <div class="flex flex-wrap justify-center gap-2 mt-4">
                            <x-button rounded class="m-2 p-2" green href="https://line.me/ti/p/%40PetsSociety"
                                label="Line : @PetsSociety" />
                            <x-button rounded class="m-2 p-2" sky href="https://www.facebook.com/PetsSocietybyZoetis"
                                label="facebook.com/PetsSocietybyZoetis" />
                        </div>

                        </p>
                    </div>
                    <div class="flex justify-between py-2 text-center mt-auto" wire:loading.remove>
                        <x-button lg {{-- right-icon="chevron-right"  --}} primary
                            class="bg-gradient-to-br  from-warning-600 to-negative-600 rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="step(3)" type="button" label="ยกเลิก" />

                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="step(6)" type="button" label="ยืนยัน" />
                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                </div>
            @break

            @case(6)
                {{-- confirm vet --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    {{-- confirm page --}}

                    <h3 class="text-center text-xl my-4 pt-4 font-bold text-primary-blue"> กรุณากรอกรหัสคลินิก <br>หรือ
                        โรงพยาบาลสัตว์ </h3>
                    <p class="text-center mb-8">
                        (สอบถามที่พนักงานของคลินิก)
                    </p>
                    <x-input wire:model="data.vet_id" label="รหัสคลินิก หรือ โรงพยาบาลสัตว์"
                        placeholder="รหัสคลินิก หรือ โรงพยาบาลสัตว์" />

                        @if($client->vet->stock->current()['remaining']<=0)
                        <span class="p-2 block pointer-events-none opacity-50">
                            <x-checkbox lg class="rounded-full" 
                                label="รับคำปรึกษาและเข้าร่วมโปรแกรม {{env('APP_NAME')}}" description="ไม่สามารถเลือกได้" />
                        </span>
                        @else
                            @if (env('VET_OPTION_1',true))
                                <span class="p-2 block"><x-checkbox lg class="rounded-full" label="รับคำปรึกษาและเข้าร่วมโปรแกรม {{env('APP_NAME')}}"
                                    id="standard"    wire:model.lazy="data.offer_1" /></span>
                            @endif
                            @if (env('VET_OPTION_2',true))
                            <span class="p-2 block"><x-checkbox lg class="rounded-full" label="รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม 1 เดือน"
                                id="extra_1" wire:model.live="data.offer_2" /></span>
                            @endif
            
                            @if (env('VET_OPTION_3',true))
                            <span class="p-2 block"><x-checkbox lg class="rounded-full" label="รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม {{ $data['offer_month']??3 }} เดือน"
                                id="extra_2" wire:model.live="data.offer_3" /></span>
                            @endif
                        @endif
                        @if ($data['offer_3'])
                            {{-- @if (env('VET_OPTION_3_option',true)) --}}
                            <span class="p-2 {{env('VET_OPTION_3_option')?'block':'hidden'}}">
                                <x-native-select label="ระยะเวลา" placeholder="เลือกระยะเวลา" 
                                    :options="[
                                        ['name' => '3 เดือน',  'value' => 3],
                                        ['name' => '6 เดือน',  'value' => 6],
                                        ['name' => '9 เดือน',  'value' => 9],
                                        ['name' => '12 เดือน',  'value' => 12],
                                        ['name' => '15 เดือน',  'value' => 15],
                                        ['name' => '18 เดือน',  'value' => 18],
                                        ['name' => '21 เดือน',  'value' => 21],
                                        ['name' => '24 เดือน',  'value' => 24],
                                        ['name' => '27 เดือน',  'value' => 27],
                                        ['name' => '30 เดือน',  'value' => 30],
                                        ]" 
                                    option-label="name" option-value="value"
                                    wire:model.live="data.offer_month" />
                            </span>
                            {{-- @endif --}}
                        @endif

                    <div class="flex justify-between py-2 text-center mt-auto" wire:loading.remove>
                        <x-button lg {{-- right-icon="chevron-right"  --}} primary
                            class="bg-gradient-to-br  from-warning-600 to-negative-600 rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="step(3)" type="button" label="ยกเลิก" />

                        <x-button lg right-icon="chevron-right" primary
                            class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl" {{-- wire:click="varifyOTP" --}}
                            wire:click="checkRmktVet" type="button" label="รับสิทธิ์" />
                    </div>
                    <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
                        กำลังดำเนินการ...
                    </div>
                </div>
            @break

            @case(7)
                {{-- opt out --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    <div class="my-auto pb-2 text-center">
                        ท่านสามารถ กด Link เพื่อรับสิทธิ์ <br>
                        จาก Email และ SMS<br>
                        ได้อีกครั้งภายหลัง เมื่อต้องการใช้สิทธิ <br>ที่คลินิกหรือโรงพยาบาลสัตว์
                    </div>
                    <img class="my-4 px-8" src="{{ asset('img/app-banner.png') }}" />
                </div>
            @break

            @case(8)
                {{-- ending --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    <p class="text-center mb-8">
                        น้อง {{ $client->pet_name ?? '' }}<br>
                        ขนาด {{ $client->pet_weight ?? '' }}<br>
                        ไปรับคำปรึกษา และเข้าร่วมโปรแกรม {{env('APP_NAME')}}<br>
                        ที่ {{ $rmktClient->vet->vet_name ?? '?' }}<br>
                    </p>
                    <p class="text-center">
                        รหัส
                        <span class="text-center text-xl mb-8 p-4 font-bold text-white bg-primary-blue block">
                            
                            REVO{{ Str::padLeft($rmktClient->id,5,'0') ?? '-ERROR' }}
                        </span>
                    </p>
                </div>
            @break

            @case(9)
                {{-- defult case --}}
                <div class="setup-content min-h-[70vh] flex flex-col transition-all">
                    <p class="text-center mb-8">
                        เกิดข้อผิดพลาด
                    </p>
                </div>
            @break

            @case(10)
            @break

            @default
        @endswitch
    @endisset
</div>
