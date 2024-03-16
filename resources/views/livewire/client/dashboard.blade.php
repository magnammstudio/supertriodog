<div class="text-content-dark relative min-h-[50vh]">
    @if(env('APP_DEBUG'))
    <x-button label="reset" wire:click="resetStatus"/>
        @if($errors->count() >0)
            error : <span>{{ var_dump($errors) }}</span>
        @endif
    @endif
    <div class="text-center absolute inset-0 z-50 " wire:loading>
        <img class="m-auto" src="{{asset('/img/loading.gif')}}"/>
    </div>
    
    <div class="row setup-content  min-h-[70vh] flex flex-col {{ $currentStep != 1 ? 'hidden' : '' }}" id="step-4">
        {{-- progress bar --}}
        <div class="flex justify-around relative">
            <progress value="5" max="5" style="
                position: absolute;
                top: calc(50% - .25rem);
                bottom: calc(50% - .25rem);
                left: auto;
                right: auto;
                height:0.5rem;
                width: calc(100% - 5rem);
                z-index: 0;
            ">
            </progress>
            <x-button.circle primary href="#step-1" label="1" style="aspect-ratio: 1/1; z-index:1;" class="rounded-full font-bold bg-primary-blue  ring ring-primary-blue hover:text-primary-blue text-gray-light" />
            <x-button.circle primary href="#step-2" label="2" style="aspect-ratio: 1/1; z-index:1;" class="rounded-full font-bold bg-primary-blue  ring ring-primary-blue hover:text-primary-blue text-gray-light" />
            <x-button.circle primary href="#step-3" label="3" style="aspect-ratio: 1/1; z-index:1;" class="rounded-full font-bold bg-primary-blue  ring ring-primary-blue hover:text-primary-blue text-gray-light" />
            <x-button.circle primary href="#step-4" label="4" style="aspect-ratio: 1/1; z-index:1;" class="rounded-full font-bold bg-primary-blue  ring ring-primary-blue hover:text-primary-blue text-gray-light" disabled="disabled" />
        </div>

        <h3 class="text-center text-xl my-4 p-4 font-bold text-white bg-primary-blue"> การลงทะเบียนเสร็จสมบูรณ์ </h3>
        
        <p class="text-center">
            ท่านได้รับสิทธิ์ รับคำปรึกษา <br>
            และเข้าร่วมโปรแกรม {{env('APP_NAME')}}<br>
            {{env('APP_TAGLINE')}}
        </p>
        <img class="my-4" src="{{asset('/img/app-banner.png')}}"/>
        <p class="text-center">
            สามารถพา {{$client->pet_name}}<br>
            ขนาด {{$client->pet_weight}}<br>
            ไปรับคำปรึกษา
            และเข้าร่วมโปรแกรม <br>{{env('APP_NAME')}}<br>
            ได้ที่โรงพยาบาล/คลินิก {{$client->vet_id?App\Models\Vet::find($client->vet_id)->vet_name:'-'}}<br>
        </p>
        <p class="text-center text-sm text-secondary-red">
            กรุณากดรับสิทธิ์ขณะอยู่ที่คลินิกตามที่ลงทะเบียน <br>
            เพื่อโชว์หลักฐานการลงทะเบียนให้คลินิกรับทราบ <br>
            (รหัสมีอายุ 15 นาที)
        </p>
        <div class="py-2 text-center flex justify-center mt-auto" wire:loading.remove>
            <x-button lg right-icon="chevron-right" primary class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl"
                wire:click="step(2)" type="button" label="กดเพื่อแสดงหลักฐาน" />
        </div>
        <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
            กำลังเนินการ...
        </div>
    </div>


    <div class="row setup-content  min-h-[70vh] flex flex-col {{ $currentStep != 2 ? 'hidden' : '' }}" id="step-4">
        <div class="text-center my-8 p-4 rounded-3xl text-white bg-primary-blue">
            <p class="my-4 leading-relaxed text-2xl">
                รหัสจะมีอายุ 15 นาที <br>
                ท่านจะสามารถใช้งานได้<br>
            </p><p class="my-4 leading-relaxed text-2xl">
                กรุณากดรับสิทธิ์ขณะอยู่ที่คลินิก<br>
                หรือ โรงพยาบาลสัตว์<br>
                ที่ลงทะเบียนเท่านั้น
            </p>
            <p class="my-4 leading-relaxed text-2xl">
                มิฉะนั้น รหัส<br>
                จะไม่สามารถใช้งานได้ <br>
                หากมีข้อสงสัย ติดต่อ <br>
                <div class="flex flex-wrap justify-center gap-2 mt-4">
                    <x-button rounded class="m-2 p-2"  green href="https://line.me/ti/p/%40PetsSociety" label="Line : @PetsSociety" />
                    <x-button rounded class="m-2 p-2"  sky href="https://www.facebook.com/PetsSocietybyZoetis" label="facebook.com/PetsSocietybyZoetis" />
                </div>

            </p>
        </div>
        <div class="py-2 text-center flex justify-between mt-auto" wire:loading.remove>
            
            <x-button lg outline icon="chevron-left"
                wire:click="step(1)" type="button" label="ยกเลิก" />
            <x-button lg right-icon="chevron-right" primary  class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl"
                wire:click="step(3)" type="button" label="กดเพื่อแสดงหลักฐาน" />
        </div>
        <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
            กำลังเนินการ...
        </div>
    </div>

    <div class="row setup-content  min-h-[70vh] flex flex-col {{ $currentStep != 3 ? 'hidden' : '' }}" id="step-4">
        <h3 class="text-center text-xl my-4 pt-4 font-bold text-primary-blue"> กรุณากรอกรหัสคลินิก <br>หรือ โรงพยาบาลสัตว์ </h3>
        <p class="text-center mb-8">
            (สอบถามที่พนักงานของคลินิก)
        </p>
        <x-errors/>
        <x-input wire:model.live.debounce.500ms="request.vet_id" label="รหัสคลินิก หรือ โรงพยาบาลสัตว์" placeholder="รหัสคลินิก หรือ โรงพยาบาลสัตว์"/>
        <div class="mt-2">

        @if ($status == -2)
            <div class="my-2">
                <x-badge negative label="จำเป็นต้องเลือกอย่างน้อย 1 ตัวเลือก" />
            </div>
        @endif
            
            @if($client->vet->stock->current()['remaining']<=0)
            <span class="p-2 block pointer-events-none opacity-50">
                <x-checkbox lg class="rounded-full" 
                    label="รับคำปรึกษาและเข้าร่วมโปรแกรม {{env('APP_NAME')}}" description="ไม่สามารถเลือกได้" />
            </span>

            @else
                @if (env('VET_OPTION_1',true))
                    <span class="p-2 block">
                        <x-checkbox name="{{env('RMKT_OPTION')?'option':'option_1'" lg class="rounded-full" label="รับคำปรึกษาและเข้าร่วมโปรแกรม {{env('APP_NAME')}}"
                        id="standard"    wire:model.live="request.offer_1" /></span>
                @endif
                @if (env('VET_OPTION_2',true))
                <span class="p-2 block">
                    <x-checkbox name="{{env('RMKT_OPTION')?'option':'option_2'" lg class="rounded-full" label="รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม 1 เดือน"
                    id="extra_1" wire:model.live="request.offer_2" /></span>
                @endif

                @if (env('VET_OPTION_3',true))
                <span class="p-2 block">
                    <x-checkbox name="{{env('RMKT_OPTION')?'option':'option_3'" lg class="rounded-full" label="รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม {{ $request['offer_month']??3 }} เดือน"
                    id="extra_2" wire:model.live="request.offer_3" /></span>
                @endif
            @endif
            @if ($request['offer_3'])
                @if (env('VET_OPTION_3_option',true))
                <span class="p-2 block">
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
                        wire:model.live="request.offer_month" />
                </span>
                @endif
            @endif
            
        </div>
        <div class="py-2 text-center flex justify-center mt-auto" wire:loading.remove>
            <x-button lg right-icon="chevron-right" primary  class="bg-gradient-to-br from-gradient-start to-gradient-end rounded-2xl
                {{$client->vet->stock->current()['remaining']<=0?'pointer-events-none opacity-50 select-none':''}}"
                wire:click="verifyVet" type="button" label="รับสิทธิ์" 
                />
        </div>
        <div class="py-2 text-center flex justify-center mt-auto" wire:loading>
            กำลังเนินการ...
        </div>
    </div>


    <div class="row setup-content  min-h-[70vh] flex flex-col {{ $currentStep != 6 ? 'hidden' : '' }}" id="step-4">
        <p class="text-center mb-8">
            น้อง {{$client->pet_name}}<br>
            ขนาด {{$client->pet_weight}}<br>
            ไปรับคำปรึกษา และเข้าร่วมโปรแกรม {{env('APP_NAME')}}<br>
            ที่ {{$client->vet_id?App\Models\Vet::find($client->vet_id)->vet_name:'-'}}<br>
        </p>
        <p class="text-center">
            รหัส
            <span class="text-center text-xl mb-8 p-4 font-bold text-white bg-primary-blue block">
                {{$client->client_code}}
            </span>
        </p>

    </div>
</div>
