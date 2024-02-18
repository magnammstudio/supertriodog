@section('title', 'Sign in to your account')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        </a>

        @if (Route::has('register'))
            <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
                Or
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    create a new account
                </a>
            </p>
        @endif
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form wire:submit.prevent="authenticate" class="grid gap-2">
                <x-input wire:model.lazy="username" label="รหัสร้านค้า"/>
                <x-inputs.password wire:model.lazy="password" label="รหัสผ่าน"/>
                <span class="my-1"> </span>
                <x-checkbox label="จดจำรหัสผ่านของฉันเอาไว้" wire:model.defer="remember"/>
                <span class="my-4"> </span>
                <x-button xl primary type="submit" right-icon="chevron-right" label="Login" wire:click="authenticate" />
            </form>
        </div>
    </div>
</div>
