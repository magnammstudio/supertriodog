<div>
    Profile: {{$client}}
    <hr>
    RMKT:
    {{$client->rmkt}}
    <x-button label="back" :href="route('admin.client.index')"/>
</div>
