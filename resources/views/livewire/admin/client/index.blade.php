<div>
    show all client filter by vet 

    show main profile and rmkt profile

    summerise number of active visit
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div>
        {{-- <table>
            <tr>

            </tr> --}}

            @foreach ($clients as $client)
                <div>
                    <x-button :label="$client->name" :href="route('admin.client.profile',$client->client_code)"/>
                    
                    @isset($client->rmkt)
                    <div>
                    @foreach ($client->rmkt as $rmkt)
                        <x-badge :label="$rmkt->vet_id"/>
                        <x-badge :label="$rmkt->vet_id"/>
                        
                        {{-- {{dd($rmkt)}} --}}
                    @endforeach
                    </div>
                    @endisset
                    {{$client->profile()}}
                </div>
            @endforeach
        {{-- </table> --}}
    </div>
</div>
