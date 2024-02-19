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
    </x-card>
    @foreach ($vets as $vet)
            <div class="grid grid-cols-4 items-start w-full"x-data="{ open: false }">
                <div class="col-span-3">
                    {{$vet->id}} : {{$vet->vet_name}} <br>
                    @isset($vet->stock)
                        stock id {{$vet->stock->id}} : total {{$vet->stock->total_stock}}<br>
                    @endisset
                    @isset($vet->user)
                        Have User<br>
                    @endisset
                </div>
                <div class="flex">
                    <x-button icon="x" @click="open = ! open" />
                    <x-button icon="home" wire:click="edit"/>
                </div>
                <div class="col-span-4 flex flex-wrap gap-1" x-show="open" x-transition>
                    
                    <x-button icon="x" label="user" wire:click="deleteUser({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                    class="{{($vet->user!=null)?'':'opacity-45 pointer-events-none'}}"
                    />
                    <x-button icon="x" label="stock" wire:click="deleteStock({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                    class="{{($vet->stock!=null)?'':'opacity-45 pointer-events-none'}}"
                    />
                    <x-button icon="x" label="vet" wire:click="deleteVet({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                    class="{{($vet->user==null && $vet->stock==null)?'':'opacity-45 pointer-events-none'}}"
                    />
                    <x-button icon="x" label="all" wire:click="deleteAll({{$vet}})" wire:confirm="คุณต้องการยืนยันการลบหรือไม่"
                    />
                </div>
            </div>
            <hr class="clear-both mb-6">
    @endforeach
</div>
