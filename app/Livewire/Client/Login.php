<?php

namespace App\Livewire\Client;

use App\Models\client;
use Livewire\Component;

class Login extends Component
{
    public $phone;
    public $error=null;
    public function mount($phone=null){
        if($phone){
            $this->phone=$phone;
            $this->login();
        }
    }
    public function render()
    {
        return view('livewire.client.login');
    }

    public function login(){
        // validate
        $validatedData = $this->validate([
            'phone' => ['required', 'numeric','digits:10','min:10','regex:/^([0-9\s\(\)]*)$/'],
        ],[
            'phone.required'=>'กรุณากรอกหมายเลขโทรศัพท์ ที่ลงทะเบียนรับสิทธิ์',
            'phone.numeric'=>'หมายเลขโทรศัพท์จะต้องเป็นตัวเลขเท่านั้น',
            'phone.digits'=>'กรุณากรอกหมายเลขโทรศัพท์ให้ครบถ้วน',
            'phone.min'=>'ขั้นต่ำ 10 ตัวอักษร',
            
        ]);
        $client = client::where('phone',$this->phone)->first();
        if($client){
            redirect(route('client.ticket',['phone'=>$this->phone]));
        }else{
            $this->error = 'ไม่พบหมายเลขในระบบ';
        }

    }
}
