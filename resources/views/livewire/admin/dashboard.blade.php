<div class="container m-auto">
    <div class="flex gap-4 flex-wrap py-2">
        <div class="p-4 px-6 rounded-xl shadow-md bg-primary-blue text-white">
            <span> Total : </span><span class="text-2xl font-bold"> {{$static['client']}} </span>
        </div>
        <div class="p-4 px-6 rounded-xl shadow-md bg-white text-primary-blue">
            <span> Complete : </span><span class="text-2xl font-bold"> {{$static['client_activated']}} </span>
        </div>
        <div class="p-4 px-6 rounded-xl shadow-md bg-white text-primary-blue">
            <span> Waiting : </span><span class="text-2xl font-bold"> {{$static['client_pending']}} </span>
        </div>
    </div>

    <div class="text-primary-blue flex justify-between flex-wrap py-2 mt-4">
        <div class="flex gap-2">
            <span>
                <p>
                    รับคำปรึกษาและเข้าร่วมโปรแกรม Super TRIO
                </p>
                <x-badge label="(Get free consultation and a tablet)" />
            </span>
            <span class="text-xl font-bold">{{$static['client_option_1']}}</span>
        </div>
        <div class="flex gap-2">
            <span>
                <p>
                    รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม 1 เดือน
                </p>
                <x-badge label="(Extra tablet sold)" />
            </span>
            <span class="text-xl font-bold">{{$static['client_option_2']}}</span>
        </div>
        <div class="flex gap-2">
            <span>
                <p>
                    รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม 3 เดือน
                </p>
                <x-badge label="(Extra box sold)" />
            </span>
            <span class="text-xl font-bold">{{$static['client_option_3']}}</span>
        </div>
    </div>

    {{-- {{$search['text']}} --}}
    <div class="flex gap-2 py-4">
        <x-input label="search" wire:model.live.debounce.700ms="search.text">
            <x-slot name="append">
                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                    <x-button flat icon="search"/>
                </div>
            </x-slot>
        </x-input>

        <x-native-select
        
            label="Select Status"
            placeholder="Select one status"
            :options="['Activated', 'Pending']"
            wire:model.live="search.status"
        />
        <x-native-select
            label="จำนวนที่แสดง"
            :options="[25,50,100,250]"
            wire:model.live="search.paginate"
        />
    </div> 
    <div class="overflow-x-auto">
        <table class="table-fixed min-w-full whitespace-nowrap">
            <thead>
                <tr class="border border-primary-blue bg-primary-blue text-primary-lite text-xs">
                    <th class="w-8">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="ลำดับ"/>
                            <x-badge primary label="No"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="วันที่"/>
                            <x-badge primary label="Date"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="ชื่อคลินิก"/>
                            <x-badge primary label="Clinic/Hospital"/>
                        </div>
                    </th>
                    <th class="">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="ชื่อลูกค้า"/>
                            <x-badge primary label="Pet owner's Name"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="น้ำหนัก สุนัข"/>
                            <x-badge primary label="Pet's weight"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="สถานะ"/>
                            <x-badge primary label="Status"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="สิทธิ์ทั้งหมด"/>
                            <x-badge primary label="All Quota"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="สิทธิ์คงเหลือ"/>
                            <x-badge primary label="Remaining Quota"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="สิทธิ์ที่รับแล้ว"/>
                            <x-badge primary label="Redeemed"/>
                        </div>
                    </th>
                    <th class="hidden sm:table-cell">
                        <div class="grid">
                            <x-button primary-blue flat class="pointer-events-none text-white hover:bg-white/20"  label="สินค้าขาด"/>
                            <x-badge primary label="Out of quota"/>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border border-primary-blue p-2">

                </tr>
                @foreach ($clients as $client)
                    <tr class="border border-primary-blue p-2">
                        <td class="align-top border border-primary-blue p-2">
                            {{$client->client_code}}
                        </td>
                        <td class="align-top sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            {{$client->created_at->toDateString()}}
                        </td>
                        <td class="align-top sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <x-button flat label="{{$vets->where('id',$client->vet_id)->first()->vet_name}}" :href="route('admin.vet',['id'=>$client->vet->id])" />
                                
                        </td>
                        <td class="align-top sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            {{$client->name}} 
                            @if (Auth::user()->isAdmin)
                                <x-button label="x" wire:click="delete({{$client}})"/>
                            @endif
                        </td>
                        <td class="align-top sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <span class="sm:hidden inline-block min-w-max mr-2">น้ำหนัก สุนัข</span>
                            {{$client->pet_weight}}
                        </td>
                        <td class="align-top sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <span class="sm:hidden inline-block min-w-max mr-2">สถานะ</span>
                            {{$client->active_status}}
                        </td>
                        <td class="align-top text-center sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <!-- สิทธิ์ทั้งหมด -->
                            <!-- total stock a -->
                            <span class="sm:hidden inline-block min-w-max mr-2">สิทธิ์ทั้งหมด</span>
                            {{$vets->find($client->vet_id)->stock->total_stock }}
                            
                        </td>
                        <td class="align-top text-center sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <!-- สิทธิ์ลงเหลือ -->
                            <!-- total stock - total activate -->
                            <span class="sm:hidden inline-block min-w-max mr-2">สิทธิ์คงเหลือ</span>
                            {{$vets->find($client->vet_id)->stock->total_stock - $vets->find($client->vet_id)->withCurrentStock()->sum('opt_1_act') }}
                            
                            {{-- {{$client->vet->stockRemaining()>0?$client->vet->stockRemaining():'-'}} --}}
                        </td>
                        <td class="align-top text-center sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <!-- สิทธิ์ที่รับแล้ว	 -->
                            <!-- total activate -->
                            <span class="sm:hidden inline-block min-w-max mr-2">สิทธิ์ที่รับแล้ว</span>
                            {{$vets->find($client->vet_id)->withCurrentStock()->sum('opt_1_act') }}
                            {{-- {{$client->vet->stockRedeemed()}} --}}
                        </td>
                        <td class="align-top text-center sm:border border-primary-blue p-2 ml-2 table sm:table-cell">
                            <span class="sm:hidden inline-block min-w-max mr-2">สินค้าขาด</span>
                            @if ($vets->find($client->vet_id)->stock->total_stock - $vets->find($client->vet_id)->withCurrentStock()->sum('opt_1') < 0)
                                {{$vets->find($client->vet_id)->stock->total_stock - $vets->find($client->vet_id)->withCurrentStock()->sum('opt_1') }}
                            @else
                                -
                            @endif
                            {{-- {{$client->vet->stockRemaining()<0?$client->vet->stockRemaining():'-'}} --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
    <div class="my-4">{{$clients->links()}}</div>
</div>
