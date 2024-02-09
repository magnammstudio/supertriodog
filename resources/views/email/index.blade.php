<div>
    <x-button label="test" wire:click="test"/>
    test button
    @php
        function test(){
            dd('test');
        }
    @endphp
</div>