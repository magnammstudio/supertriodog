<?php

namespace App\Livewire\Client;

use App\Models\client;
use App\Models\rmktClient;
use App\Models\vet;
use Livewire\Component;
use Illuminate\Support\Str;

class Rmkt extends Component
{
    public $currentStep = 1;
    public $client,$rmktClient;
    public $data;

    public $vet_list;
    public $selected_vet;
    // page note

    protected $rules=[
        'data.phone' => ['required', 'numeric','digits:10','min:10','regex:/^([0-9\s\(\)]*)$/'],
        'data.pin' => ['required', 'string', 'max:255'],
    ];


    public function mount($phone=null){
        
        $this->data=[
            'phone'=>$phone??'0809166690',
        ];
        if($phone == null){
            $this->currentStep=-1;
        }else{
            $this->client = client::where('phone',$phone)->first();
            if($this->client->rmkt->last()){
                $this->client->vet_id=$this->client->rmkt->last()->vet_id;
                // dd($this->client->rmkt->last()->vet);
            }
            if($this->client){
                $this->currentStep=3;
            }else{
                redirect(route('client.rmkt'));
            }
            // dd($this->client,$this->currentStep);
        }
    }
    public function render()
    {
        return view('livewire.client.rmkt');
    }
    public function changeVet(){
        // load vet and province
        // step(4)
        
        $vet=vet::all();
        $this->vet_list['province'] = $vet->unique('vet_province')->pluck('vet_province');

        $this->selected_vet['province']=null;
        $this->selected_vet['district']=null;
        $this->selected_vet['tambon']=null;
        $this->selected_vet['id']=null;
        $this->vet_list['name'] = $vet->pluck('vet_name','id');
        $this->currentStep =4;
        // dd($this->vet_list);
    }
    public function verifyPhoneNumber(){
        // validate phone number
        $validatedData = $this->validateOnly('data.phone');
        $phone =$this->data['phone'];
        // search for phone number 
        $client=client::where('phone',$phone)->first();

        if($client){
            // if have phone send otp and go next
            $this->currentStep =1;    
            
            // if(env('SMS_API', false)){
            //     $this->confirmation();
            // }else{
    
            // }
        }else{
            $this->addError('data.phone', 'ไม่พบข้อมูลลงทะเบียน');
        }
    }
    public function validateOTP(){
        $validatedData = $this->validateOnly('data.pin');
        // check is pin correct
        if($this->data['pin']==123456){
            $this->currentStep =3;
            redirect(route('client.rmkt',['phone'=>$this->data['phone']]));
        }else{
            $this->addError('data.pin', 'PIN Code ไม่ถูกต้อง');
        }
    }
    public function updateVet(){
        // dd($this->selected_vet['id']);
        $vet = Vet::find($this->selected_vet['id']);
        $this->client->vet_id = $vet->id;
        $this->currentStep =3;
    }
    public function savermktdata(){
        // validate data
        // save to rmkt

        // dd($this->rmktClient,$this->client->vet);
        $this->rmktClient=rmktClient::updateOrCreate([
            'client_id'=>$this->client->id,
            'active_status'=>'pending'
        ],[
            'vet_id'=>$this->selected_vet['id']??$this->client->vet_id,
            'option_1'=>$this->offer_1??null,
            'option_2'=>$this->offer_2??null,
            'option_3'=>$this->offer_3??null,
            'active_date'=>now(),
            'active_status'=>'activated'
        ]);
        // $this->rmktClient->id = 'TRIO'.Str::padLeft($this->rmktClient->id, 5, '0');
        $this->rmktClient->save();
        // dd($this->rmktClient,$this->client);
        $this->currentStep =8;
    }
    public function step($goto=null){
        $this->currentStep =$goto??$this->currentStep+1;
    }
    public function registerNew(){
        redirect(route('client.home'));
    }



    public function updatedSelectedVetProvince($selected_vet_province){
        // select province update list and district
        $vet_in_province = Vet::where('vet_province',$selected_vet_province)->get();
        $this->vet_list['city']=$vet_in_province->unique('vet_city')->pluck('vet_city');
        $this->vet_list['name']=$vet_in_province->pluck('vet_name','id');
        
        $this->selected_vet['district']=null;
        $this->selected_vet['tambon']=null;
        $this->selected_vet['id']=null;
    }
    public function updatedSelectedVetDistrict($selected_vet_district){
        // select district update list and tambon
        $vet_in_province = Vet::where('vet_city',$selected_vet_district)->get();
        $this->vet_list['area']=$vet_in_province->unique('vet_area')->pluck('vet_area');
        $this->vet_list['name']=$vet_in_province->pluck('vet_name','id');
        
        $this->selected_vet['tambon']=null;
        $this->selected_vet['id']=null;
    }
    public function updatedSelectedVetTambon($selected_vet_tambon){
        // select tambon update list
        $vet_in_province = Vet::where('vet_area',$selected_vet_tambon)->get();
        $this->vet_list['name']=$vet_in_province->pluck('vet_name','id');
        
        $this->selected_vet['id']=null;
    }
    public function updatedSelectedVetId($id){
        // select tambon update list
        $vet = Vet::find($id);
        $this->selected_vet['name']=$vet->vet_name;
        $this->selected_vet['address']=$vet->vet_area.' '.$vet->vet_city.', '.$vet->vet_province.' ';
    }
}
