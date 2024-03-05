@section('title', 'Create a new account')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        </a>

        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
            Create a new account
        </h2>

        <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
            Or
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                sign in to your account
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form wire:submit.prevent="register" class="grid gap-4">
                <x-input wire:model.live="userCode" label="User Code"/>
                <x-input wire:model.live="name" label="Name"/>
                <x-input wire:model.live="email" label="Stock"/>
                <x-inputs.password wire:model.live="password" label="Password"/>
                <x-inputs.password wire:model.live="passwordConfirmation" label="Password"/>
                
                <x-toggle wire:model.live="haveVet" label="New Vet"/>
                @if ($haveVet)
                    <x-input wire:model.live="name" label="Name"/>
                    <x-select label="province" placeholder="province"
                        wire:model.live="province" >
                        @foreach ($addr['province'] as $a)
                            <x-select.option :label="$a" :value="$a" />
                        @endforeach
                    </x-select>
                    @isset($province)
                        <x-select label="district" placeholder="district"
                            wire:model.live="district" >
                            @foreach ($addr['district'] as $a)
                                <x-select.option :label="$a" :value="$a" />
                            @endforeach
                        </x-select>
                    @endisset
                    @isset($district)
                        <x-select label="tambon" placeholder="tambon"
                            wire:model.live="tambon" >
                            @foreach ($addr['tambon'] as $a)
                                <x-select.option :label="$a" :value="$a" />
                            @endforeach
                        </x-select>
                    @endisset
                    <x-input wire:model.live="stockID" label="Stock ID"/>
                    <x-input wire:model.live="stockTotal" label="Stock Total"/>
                @else
                <x-input wire:model.live="vetId" label="Vet ID"/>
                @endif

                <div class="mt-6 grid">
                    <x-button primary xl type="submit" label="Register"/>
                </div>
            </form>
        </div>
    </div>
</div>
