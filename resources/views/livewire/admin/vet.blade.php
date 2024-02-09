<div>
    <div class="flex justify-between">
        <div>
            <h2 class="text-lg text-primary-blue font-bold">
                {{ $vet->vet_name }}
            </h2>
            <p>
                {{$vet->vet_area}} {{$vet->vet_city}} {{$vet->vet_province}}
            </p>
        </div>
        <x-badge class="rounded-2xl bg-primary-blue text-white p-4 shadow-lg" label="รหัส : 839703" />
    </div>
    <hr class="border-2 border-primary-blue my-4">
    <div class="grid sm:grid-cols-2 my-4 gap-4">
        <div>
            <div class="flex gap-2">
                <div class=" rounded-2xl bg-primary-blue text-primary-lite/70 p-4 shadow-lg ">
                    Total :
                    <span class="text-2xl font-bold block">
                        {{$stock->sum('client_all')}}
                    </span>
                </div>
                <div class=" rounded-2xl text-black/70 p-4 shadow-lg ">
                    Complete :
                    <span class="text-2xl font-bold block">
                        {{$stock->sum('c_activated')}}
                        {{-- {{$vet->client->where('active_status','activated')->count()}} --}}
                    </span>
                </div>
                <div class=" rounded-2xl text-black/70 p-4 shadow-lg ">
                    Waiting :
                    <span class="text-2xl font-bold block">
                        {{$stock->sum('client_all') - $stock->sum('c_activated') }}
                        {{-- {{$vet->client->count()-$vet->client->where('active_status','activated')->count()}} --}}
                    </span>
                </div>
            </div>
            <p class="mt-4 flex gap-2"> 
                <span>รับคำปรึกษาและเข้าร่วมโปรแกรม Super TRIO <br>
                    <x-badge label="(Get free consultation and a tablet)"/></span>
                <span class="font-bold text-xl text-black/70">

                    {{$stock->sum('opt_1')}}
                    {{-- {{$vet->client->where('option_1')->count()}} --}}
                </span>
            </p>
            <p class="mt-2 flex gap-2">
                <span>รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม 1 เดือน <br>
                    <x-badge label="(Extra tablet sold)"/></span>
                <span class="font-bold text-xl text-black/70">
                    {{$stock->sum('opt_2')}}
                    {{-- {{$vet->client->where('option_2')->count()}} --}}
                </span>
            </p>
            <p class="mt-2 flex gap-2">
                <span>รับสิทธิ์พิเศษเพิ่มเติม - เข้าโปรแกรม 3 เดือน <br>
                    <x-badge label="(Extra box sold)"/></span>
                <span class="font-bold text-xl text-black/70">
                    {{$stock->sum('opt_3')}}
                    {{-- {{$vet->client->where('option_3')->count()}} --}}
                </span>
            </p>
        </div>
        <div>
            <div class="flex gap-2 justify-end">
                <div class=" rounded-2xl text-black/70 p-2 shadow-lg ">
                    สินค้าทั้งหมด
                    <x-badge label="All Quota" />
                    <span class="text-2xl font-bold block">
                        
                        {{$vet->stock->total_stock}}
                    </span>
                </div>
                <div class=" rounded-2xl text-black/70 p-2 shadow-lg ">
                    จำนวนครั้งที่เติม
                    <x-badge label="Remaining Quota" />
                    <span class="text-2xl font-bold block">
                        
                        {{$vet->stock->stock_adj}}
                    </span>
                </div>
                <div class=" rounded-2xl text-black/70 p-2 shadow-lg ">
                    สินค้าคงเหลือ
                    <x-badge label="Remaining Quota" />
                    <span class="text-2xl font-bold block">
                        
                        {{$vet->stock->total_stock - $vet->stockRedeemed()}}
                    </span>
                </div>
                <div class=" rounded-2xl bg-red-300 text-black/70 p-2 shadow-lg ">
                    สินค้าขาด
                    <x-badge label="Out of quota" />
                    <span class="text-2xl font-bold block">
                        
                        {{($vet->stock->total_stock - $vet->stockRedeemed())<0?($vet->stock->total_stock - $vet->stockRedeemed()):'-'}}
                    </span>
                </div>
            </div>
            <div class="text-right rounded-2xl text-black/70 p-4 shadow-lg ">
                <x-inputs.number wire:model="stock_adj" label="จำนวนสินค้าที่เติม : " />
                <x-button primary class="my-4" label="บันทึก" wire:click="add_stock_adj" />
            </div>
        </div>
    </div>
    <div>
        <!-- updated_at | desc -->
        <div class="mt-7 overflow-x-auto">
            @if ($vetClients)
            <table class="min-w-full table-fixed">
                <thead>
                    <tr class="border border-primary-blue bg-primary-blue  text-xs">
                        <th class="w-24">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 w-full hover:bg-white/10"
                                    wire:click="order('client_code')"> ลำดับ
                                </button>
                                <x-badge primary label="No" />
                            </div>
                        </th>
                        <th class="w-24 hidden sm:table-cell">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 w-full hover:bg-white/10"
                                    wire:click="order('updated_at')"> วันที่
                                </button>
                                <x-badge primary label="Date" />
                            </div>
                        </th>
                        <th class="">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 w-full hover:bg-white/10"
                                    wire:click="order('name')"> ชื่อลูกค้า
                                </button>
                                <x-badge primary label="Pet owner's Name" />
                            </div>
                        </th>
                        <th class="w-20 text-primary-lite">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 pointer-events-none w-full block hover:bg-white/10">
                                    รับคำปรึกษาและเข้าร่วม โปรแกรม Super TRIO
                                </button>
                                <x-badge primary label="(Get free consultation and a tablet)" />
                            </div>
                        </th>
                        <th class="w-20 text-primary-lite hidden sm:table-cell">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 pointer-events-none w-full block hover:bg-white/10">
                                    รับสิทธิ์พิเศษเพิ่มเติม - เข้าร่วมโปรแกรม 1 เดือน
                                </button>
                                <x-badge primary label="(Extra tablet sold)" />
                            </div>
                        </th>
                        <th class="w-20 text-primary-lite hidden sm:table-cell" colspan="2">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 pointer-events-none w-full block hover:bg-white/10">
                                    รับสิทธิ์พิเศษเพิ่มเติม - เข้าร่วมโปรแกรม 3 เดือน
                                </button>
                                <x-badge primary label="(Extra box sold)" />
                            </div>
                        </th>
                        <th class="w-24 hidden sm:table-cell text-primary-lite">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 pointer-events-none w-full block hover:bg-white/10">
                                    น้ำหนัก สุนัข
                                </button>
                                <x-badge primary label="Pet's weight" />
                            </div>
                        </th>
                        <th class="w-24 hidden sm:table-cell">
                            <div class="grid">
                                <button wire:loading.attr="disabled" wire:loading.class="!cursor-wait" type="button"
                                    class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     text-white hover:bg-slate-100 ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-700 dark:ring-slate-600 dark:ring-offset-slate-800 w-full hover:bg-white/10"
                                    wire:click="order('active_status')"> สถานะ
                                </button>
                                <x-badge primary label="Status" />
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vetClients as $client)
                    <tr class="border border-primary-blue">
                        <td class="align-top sm:border mx-2 border-primary-blue p-2 table w-full sm:w-auto sm:table-cell">{{$client->client_code}}</td>
                        <td class="align-top sm:border mx-2 border-primary-blue p-2 table w-full sm:w-auto sm:table-cell">
                            {{$client->updated_at->format('d/m/y')}}
                        </td>
                        <td class="align-top border whitespace-nowrap border-primary-blue p-2 sm:table-cell">
                            {{$client->name}}
                            <x-badge primary label="{{$client->phone}}" />
                        </td>
                        <td class="align-top sm:border mx-2 whitespace-nowrap border-primary-blue p-2 table w-full sm:w-auto sm:table-cell sm:text-center ">
                            @if($client->option_1)
                            <x-badge.circle positive icon="check" class="w-5 h-5 m-auto p-2 inline-block" />
                            <span class="sm:hidden inline-block min-w-max mx-2 my-1">เข้าร่วม โปรแกรม Super TRIO</span>
                            @endif
                        </td>
                        <td class="align-top sm:border mx-2 whitespace-nowrap border-primary-blue p-2 table w-full sm:w-auto sm:table-cell sm:text-center ">
                            @if($client->option_2 )
                            <x-badge.circle positive icon="check" class="w-5 h-5 m-auto p-2 inline-block" />
                            <span class="sm:hidden inline-block min-w-max mx-2 my-1">เข้าร่วมโปรแกรม 1 เดือน</span>
                            @endif
                        </td>
                        <td class="align-top sm:border mx-2 whitespace-nowrap border-primary-blue p-2 table w-full sm:w-auto sm:table-cell sm:text-center ">
                            @if($client->option_3 )
                            <x-badge.circle positive icon="check" class="w-5 h-5 m-auto p-2 inline-block" />
                            @endif
                        </td>
                        <td class="align-top sm:border mx-2 whitespace-nowrap border-primary-blue p-2 table w-full sm:w-auto sm:table-cell sm:text-center ">
                            @if($client->option_3 )
                            <span class="sm:hidden inline-block min-w-max mx-2 my-1">เข้าร่วมโปรแกรม </span>{{ $client->option_3 }} เดือน
                            @endif

                        </td>
                        <td class="align-top sm:border mx-2 whitespace-nowrap border-primary-blue p-2 sm:text-center table w-full sm:w-auto sm:table-cell">
                            <span class="sm:hidden inline-block min-w-max mx-2 mt-1">น้ำหนัก สุนัข : </span> {{$client->pet_weight}}
                        </td>
                        <td class="align-top sm:border mx-2 whitespace-nowrap border-primary-blue p-2 sm:text-center table w-full sm:w-auto sm:table-cell">
                            <span class="sm:hidden inline-block min-w-max mx-2">สถานะ : </span> {{$client->active_status??'-'}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="my-4">
            {{$vetClients->links()}}
        </div>
        @else
        <div>No client regis yet</div>
        @endif
    </div>
</div>
