<div class="grid grid-cols-3 gap-2">
<div class="col-span-3">
<x-errors/>
<x-notifications />
</div>
    <x-card title="User">
        @if ($vet->user)
        <x-input label="id" wire:model="data.user_id"/>
        <x-input label="name" wire:model="data.user_name"/>
        
        <x-input label="password" wire:model="data.user_password" />
        @else
        <x-button label="create User" wire:click="createUser"/>
        @endif
    </x-card>
    <x-card title="Vet">
        {{-- {{dd($data)}} --}}
        
        <form wire:submit.prevent="saveVet">
            <x-input label="Vet ID" wire:model="data.id"/>
            <x-input label="name" wire:model="data.vet_name"/>
            <x-input label="province" wire:model="data.vet_province"/>
            <x-input label="district" wire:model="data.vet_city"/>
            <x-input label="tambon" wire:model="data.vet_area"/>
            <x-input label="Stock ID" wire:model="data.stock_id"/>
            <x-input label="User ID" wire:model="data.user_id"/>
        </form>
        
        <x-button label="save" wire:click="saveVet" />
    </x-card>
    
    <x-card title="Stock">
        <form wire:submit.prevent="saveStock">
            <x-input label="Stock ID" wire:model="data.stock_id"/>
            <x-input label="Total Stock" wire:model="data.total_stock"/>
            <x-input label="Stock Adj" wire:model="data.stock_adj"/>
        </form>
        <x-button label="save" wire:click="saveStock" />
        <div>
        @isset($vet->stock)
        @foreach ( $vet->stock->current() as $key=>$value )
        {{$key}} : {{$value}}<br>
        @endforeach
        @endisset
        </div>
    </x-card>
</div>
