<div>
    
    <div class="overflow-x-auto" id="vets">
        <div class="flex justify-start gap-4 my-4">
            <div class="bg-primary-blue rounded-2xl text-primary-lite p-4 shadow-lg flex gap-2">
                Total :
                <span class="text-4xl font-black">
                    {{$total_stock}}
                </span>
            </div>

        </div>

    {{-- {{$search['text']}} --}}
    <div class="flex gap-2 py-4">
        <x-input label="ค้นหา" wire:model.live.debounce.1000ms="search.text" hint="ค้นหา ชื่อ ที่อยู่ หรือรหัสสถานพยาบาล" >
            <x-slot name="append">
                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                    <x-button flat icon="search"/>
                </div>
            </x-slot>
        </x-input>
        <span class="w-44">
            <x-native-select 
            label="จำนวนที่แสดง"
            :options="[25,50,100,250]"
            wire:model.live="search.paginate"
            />
        </span>
    </div>
        <div class="w-full overflow-x-auto">
            <table class="table-fixed border-collapse border border-primary-blue whitespace-nowrap min-w-full ">
                <thead>
                    <tr class="border border-primary-blue bg-primary-blue text-primary-lite text-xs">
                        <th class="w-4 md:w-1/12">
                            <div class="grid">
                            <x-button flat white  class="w-full hover:bg-white/10" label="รหัส" />
                            <x-badge primary label="Code" />
                            </div> 
                        </th>
                        <th class="md:w-4/12">
                            <div class="grid">
                            <x-button flat white  class="w-full hover:bg-white/10" label="ชื่อคลินิก" />
                            <x-badge primary label="Clinic/Hospital" />
                            </div>
                        </th>
                        <th class="w-1/12 hidden md:table-cell">
                            <div class="grid">
                            <x-button flat white class="pointer-events-none w-full block hover:bg-white/10" label="สิทธิ์ทั้งหมด" />
                            <x-badge primary label="All Quota" />
                            </div>
                        </th>
                        <th class="w-1/12 hidden md:table-cell">
                            <div class="grid">
                            <x-button flat white class="pointer-events-none w-full block hover:bg-white/10" label="สิทธิ์ที่รับแล้ว" />
                            <x-badge primary label="Redeemed" />
                            </div>
                        </th>
                        <th class="w-1/12 hidden md:table-cell">
                            <div class="grid">
                            <x-button flat white class="pointer-events-none w-full block hover:bg-white/10" label="สิทธิ์คงเหลือ" />
                            <x-badge primary label="Remaining Quota" />
                            </div>
                        </th>
                        <th class="w-1/12 hidden md:table-cell">
                            <div class="grid">
                            <x-button flat white class="pointer-events-none w-full block hover:bg-white/10" label="สิทธิ์ที่รอ" />
                            <x-badge primary label="Pending" />
                            </div>
                        </th>
                        <th class="w-1/12 hidden md:table-cell">
                            <div class="grid">
                            <x-button flat white class="pointer-events-none w-full block hover:bg-white/10" label="ครั้งที่เติมสิทธิ์" />
                            <x-badge primary label="Quota Redeemed" />
                            </div>
                        </th>
                        <th class="w-1/12 hidden md:table-cell">
                            <div class="grid">
                            <x-button flat white class="pointer-events-none w-full block hover:bg-white/10" label="สินค้าขาด" />
                            <x-badge primary label="Out of quota" />
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vets as $vet)
                    <tr class="border border-primary-blue">
                        <td class="align-top border border-primary-blue p-2 whitespace-nowrap">
                            <x-button flat :label="$vet->vet_remark['id']??$vet->id" :href="route('admin.vet',[$vet->id])" />
                        </td>
                        <td class="align-top md:border border-primary-blue p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <x-button flat :label="$vet->vet_name" :href="route('admin.vet',$vet->id)" />
                            <span class="whitespace-nowrap flex">
                                <x-badge outline label="{{$vet->vet_province}}" />
                                <x-badge outline label="{{$vet->vet_city}}" />
                                <x-badge outline label="{{$vet->vet_area}}" />
                            </span>
                        </td>
                        <td class="align-top md:border border-primary-blue md:text-right p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <span class="md:hidden inline-block min-w-max mr-2">สิทธิ์ทั้งหมด</span>
                            {{$vet->stock->total_stock??'-'}}
                        </td>
                        <td class="align-top md:border border-primary-blue md:text-right p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <span class="md:hidden inline-block min-w-max mr-2">สิทธิ์ที่รับแล้ว</span>
                            {{$vet->stock->current()['redeemed']}}
                        </td>
                        <td class="align-top md:border border-primary-blue md:text-right p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <span class="md:hidden inline-block min-w-max mr-2">สิทธิ์คงเหลือ</span>
                            {{$vet->stock->current()['remaining']}}
                        </td>
                        <td class="align-top md:border border-primary-blue md:text-right p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <span class="md:hidden inline-block min-w-max mr-2">สิทธิ์ที่รอ</span>
                            {{$vet->stock->current()['pending']}}
                        </td>
                        <td class="align-top md:border border-primary-blue md:text-right p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <span class="md:hidden inline-block min-w-max mr-2">ครั้งที่เติมสิทธิ์</span>
                            {{$vet->stock->stocks_adj??0}}
                        </td>
                        <td class="align-top md:border border-primary-blue md:text-right p-2 ml-2 table w-full md:w-auto md:table-cell">
                            <span class="md:hidden inline-block min-w-max mr-2">สิทธิ์ที่ขาด</span>
                            {{$vet->stock->current()['outQuota']}}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="my-4">
            {{ $vets->links() }}
        </div>
    
</div>
