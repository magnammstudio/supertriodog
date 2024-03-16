<?php

namespace App\Livewire\Client;

use App\Models\client;
use App\Models\rmktClient;
use App\Models\vet;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use GuzzleHttp\Client as smsClient;

class Rmkt extends Component
{
    public $currentStep = 1;
    public $client,$rmktClient;
    public $data;

    public $vet_list;
    public $selected_vet;
    public $chooseMonth;

    public $debug;
    // page note

    protected $rules=[
        'data.phone' => ['required', 'numeric','digits:10','min:10','regex:/^([0-9\s\(\)]*)$/'],
        'data.pin' => ['required', 'string', 'max:255'],
        'data.vet_id' => ['required', 'string', 'max:255'],
    ];


    public function mount($phone=null){
        
        $this->data=[
            'phone'=>$phone,
            'offer_1'=>null,
            'offer_2'=>null,
            'offer_3'=>null,
        ];

        if($phone == null){
            $this->currentStep=-1;
        }else{
            $this->client = client::where('phone',$phone)->first();
            if($this->client){
                // $clientLastRMKTActive = $this->client->rmkt->where('active_status','activated')->last();
                // if($clientLastRMKTActive){
                //     $this->client->option_1=$clientLastRMKTActive->option_1;
                //     $this->client->option_2=$clientLastRMKTActive->option_2;
                //     $this->client->option_3=$clientLastRMKTActive->option_3;

                //     $this->debug='client have active rmkt data';
                //     // client have rmkt active data 
                //     // client last time active remarketing 
                //     $this->client->vet_id=$clientLastRMKTActive->vet_id;
                //     $this->data['offer_1']=null;
                //     $this->data['offer_2']=null;
                //     $this->data['offer_3']=null;
                // }else{
                //     $this->debug='client no active rmkt data or pending';   
                // }
                // if($this->client->option_2){
                //     $this->data['offer_1']=null;
                //     $this->data['offer_2']=null;
                //     $this->data['offer_3']=true;
                // }else{
                //     $this->data['offer_1']=null;
                //     $this->data['offer_2']=true;
                //     $this->data['offer_3']=null;
                // }
                // $this->client->option_1=$this->data['offer_1'];
                // $this->client->option_2=$this->data['offer_2'];
                // $this->client->option_3=$this->data['offer_3'];
                // dd($this->data);
                $this->currentStep=3;
            }else{
                redirect(route('client.rmkt'));
            }
            // dd($this->client,$this->currentStep);
        }
    }
    public function render()
    {
        $this->checkRmktStatus();
        return view('livewire.client.rmkt');
    }
    public function checkRmktStatus(){
        if($this->client){
            $rmktClient=$this->client->rmkt->last();
            
            if($rmktClient){
                $rmktClientActive=$this->client->rmkt->where('active_status','activated')->last();
                if($rmktClient==$rmktClientActive){
                    // dd('user can select');
                    // $lastSelect=$rmktClient->option_1??$rmktClient->option_2??$rmktClient->option_3;
                }else{
                    // $lastSelect=$rmktClientActive->option_1??$rmktClientActive->option_2??$rmktClientActive->option_3;
                    // dd('swap');
                    // $rmktClient
                }
            }else{
                if($this->client->option_2 && $this->client->option_3){
                    // dd('send remider in 25 day select option');
                    // status can select
                }else{
                    $lastSelect=$this->client->option_1??$this->client->option_2??$this->client->option_3;
                    // dd('send remider in 7 day last select : '.$lastSelect);
                }
                // dd('no rmkt swap');
            }

            if(isset($lastSelect)){
                $this->chooseMonth=$lastSelect==1?3:1;
                // dd($this->chooseMonth);
            }
            // dd($rmktClient);
        }

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
    }
    public function verifyPhoneNumber(){
        // validate phone number
        $validatedData = $this->validateOnly('data.phone');
        
        $phone =$this->data['phone'];
        // search for phone number 
        $client=client::where('phone',$phone)->first();
        if($client){
            // if have phone send otp and go next
            if(env('SMS_API', false)){
                $this->sendOTP();
            }
            // dd($client,$this->getErrorBag());
            // go next
            if($this->getErrorBag()->isEmpty()){
                $this->currentStep =1;    
            }
            
        }else{
            $this->addError('data.phone', 'ไม่พบข้อมูลลงทะเบียน');
        }
    }
    public function validateOTP(){
        $validatedData = $this->validateOnly('data.pin');
        // check is pin correct
        if(env('SMS_API', false)){
            $otpVerify=$this->verifyOTP();
        }else{
            $otpVerify=true;
        }

        // go next
        if($this->getErrorBag()->isEmpty()&&$otpVerify){
            $this->currentStep =3;
            redirect(route('client.rmkt',['phone'=>$this->data['phone']]));
        }else{
            $this->addError('data.pin', 'PIN Code ไม่ถูกต้อง');
        }
    }
    public function updateVet(){
        $vet = Vet::find($this->selected_vet['id']);
        $this->client->vet_id = $vet->id;
        $this->currentStep =3;
    }
    public function savermktdata(){
        
        $this->rmktClient=rmktClient::updateOrCreate([
            'client_id'=>$this->client->id,
            'active_status'=>'pending'
        ],[
            'vet_id'=>$this->selected_vet['id']??$this->client->vet_id,
            'option_1'=>$this->data['offer_1']??null,
            'option_2'=>$this->data['offer_2']??null,
            'option_3'=>$this->data['offer_3']??null,
            // 'active_date'=>now(),
            // 'active_status'=>'activated'
        ]);
        // dd($this->data,$this->rmktClient,$this->selected_vet['id']??$this->client->vet_id,$this->client);
        // $this->rmktClient->save();

        if(env('RMKT_GAME',false)){
            $this->currentStep =5;
            //select month and send badge
        }else{
            if($this->chooseMonth == 1){
                $this->rmktClient->option_2=1;
                $this->rmktClient->active_date=now();
                $this->rmktClient->active_status='activated';
                $this->rmktClient->save();
                $this->currentStep =8;
            }elseif($this->chooseMonth == 3){
                $this->rmktClient->option_3=3;
                $this->rmktClient->active_date=now();
                $this->rmktClient->active_status='activated';
                $this->rmktClient->save();
                $this->currentStep =8;
            }else{
                $this->currentStep =5;
            }
        }
    }
    public function checkRmktVet(){
        // check vet id 
        
        $this->validate([
            // 'request.offer_1'=>[],
            'data.vet_id'=>['required','exists:vets,id'],
            'data.offer_2'=>['required_if:data.offer_3,null'],
            'data.offer_3'=>['required_if:data.offer_2,null'],
        ],[
            'data.*'=>'จำเป็นต้องระบุ',
        ]);
        
        $vet = $this->selected_vet['id']??$this->client->vet_id;
        if($this->data['vet_id']==$vet){
            $this->rmktClient->option_1=$this->data['offer_1']??null;
            $this->rmktClient->option_2=$this->data['offer_2']??null;
            $this->rmktClient->option_3=$this->data['offer_month']??null;

            $this->rmktClient->active_status = 'activated';
            $this->rmktClient->active_date = now();
            $this->rmktClient->save();

            return $this->step(8);
        }else{
            return $this->addError('data.vet_id', 'PIN Code ไม่ถูกต้อง');
        }
    }
    public function step($goto=null){
        $this->currentStep =$goto??$this->currentStep+1;
    }
    public function registerNew(){
        redirect(route('client.home'));
    }


    public function sendOTP(){

        $SMSclient = new smsClient;

        try {
            $SMSresponse = $SMSclient->request('POST', 'https://otp.thaibulksms.com/v2/otp/request', [
                'form_params' => [
                    'key' => getenv('BULKSMS_KEY'),
                    'secret' => getenv('BULKSMS_SECRET'),
                    'msisdn' => '+66' . str_replace('-', '', $this->data['phone'])
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            ]);
            $response=json_decode($SMSresponse->getBody()->getContents());
            $this->data['token'] = $response->token;
            $this->data['refno'] = $response->refno;
            // dd($response);
        } catch (\Exception $e) {
            $this->addError('data', $e->getMessage());
            // $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function verifyOTP(){
        $SMSclient = new smsClient;

        try {
            $SMSresponse = $SMSclient->request('POST', getenv('OTP_URL').'/v2/otp/verify', [
            'form_params' => [
                'key' => getenv('BULKSMS_KEY'),
                'secret' => getenv('BULKSMS_SECRET'),
                'token' => $this->data['token'],
                'pin' => $this->data['pin']
            ],
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            ]);
        } catch (\Exception $e) {
            // $this->errorMessage = $e->getMessage();
            // dd($e->getMessage());
            $this->addError('data', $e->getMessage());
            return back()->with('error', $e->getMessage());
        }

        // dd(json_decode($response->getBody()->getContents()) , $response, $response,$this->status );

        if (json_decode($SMSresponse->getBody()->getContents())->status != 'success') {
            // $this->errorMessage = 'That code is invalid, please try again.';
            $this->addError('data','That code is invalid, please try again.');
            return false;
        }else{
            // $this->errorMessage = '';
            // $this->status = 'approved';
            return true;
        }
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

    public function updatedDataOffer1($toggle){
        $this->data['offer_1']=$this->data['offer_1']==true?true:null;
        $this->data['offer_2']=null;
        $this->data['offer_3']=null;
        if(!env('VET_OPTION_3_option') || $this->data['offer_3']!=true){
            $this->data['offer_month']=null;
        }
    }
    public function updatedDataOffer2($toggle){
        $this->data['offer_1']=null;
        $this->data['offer_2']=$this->data['offer_2']==true?true:null;
        $this->data['offer_3']=null;
        if(!env('VET_OPTION_3_option') || $this->data['offer_3']!=true){
            $this->data['offer_month']=null;
        }
    }
    public function updatedDataOffer3($toggle){
        $this->data['offer_1']=null;
        $this->data['offer_2']=null;
        $this->data['offer_3']=$this->data['offer_3']==true?true:null;
        if(!env('VET_OPTION_3_option') || $this->data['offer_3']==true){
            $this->data['offer_month']=3;
        }
    }
}
