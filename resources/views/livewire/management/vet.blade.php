<div class="w-full">
    <x-card title="Manage vet" cardClasses="mb-6">
        <x-input label="search" wire:model.live="data.search" >
            <x-slot name="append">
                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                    <x-button primary flat squared
                        class="h-full rounded-r-md"
                        icon="search" />
                </div>
            </x-slot>
        </x-input>
        
        <x-slot name="action">
            <x-button label="create" :href="route('ma.vet.edit')"/>
        </x-slot>
    </x-card>
    
    @foreach ($vets as $vet)
            <div class="flex gap-2 items-start w-full odd:bg-slate-300" 
                x-data="{ open: false }" wire:key="{{$vet->id}}">
                <div class="w-1/2">
                    <x-button label="{{$vet->id}} : {{$vet->vet_name}}" @click="open = ! open"/>
                    <br>
                    @isset($vet->stock)
                        stock id {{$vet->stock->id}} : total {{$vet->stock->total_stock}}<br>
                    @endisset
                    @isset($vet->user)
                        Have User<br>
                    @endisset
                </div>
                <div class="col-span-2 flex flex-wrap gap-1" x-show="open" x-transition>
                    
                    <x-button icon="x" label="user" wire:click="deleteUser({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                    :primary="$vet->user!=null" 
                    class="{{($vet->user!=null)?'':'opacity-45 pointer-events-none'}}"
                    />
                    @if ($vet->client->count()<=0)
                        <x-button icon="x" label="stock" wire:click="deleteStock({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                        :primary="$vet->stock!=null" 
                        class="{{($vet->stock!=null)?'':'opacity-45 pointer-events-none'}}"
                        />
                    @endif
                    @if (!$vet->stock)
                        <x-button icon="x" label="vet" wire:click="deleteVet({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                        :primary="($vet->user==null && $vet->stock==null)" 
                        class="{{($vet->user==null && $vet->stock==null)?'':'opacity-45 pointer-events-none'}}"
                        />
                    @endif
                    <x-button icon="x" label="all" wire:click="deleteAll({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                    />
                    <x-button icon="home" wire:click="edit" :href="route('ma.vet.edit',$vet)"/>
                </div>
                
            </div>
            <hr class="clear-both mb-6">
    @endforeach
</div>
