<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\vet as vetModels;
use Illuminate\Support\Facades\Hash;

class Vet extends Component
{
    use WithPagination;
    public $data=[
        'search'=>null
    ];
    public function render()
    {
        return view('livewire.management.vet',[
            'vets'=>vetModels::with('stock')->with('user')
            ->when($this->data['search']!=null,function($queryString){
                // dd($queryString->get());
                $text = $this->data['search'];
                // dd($text);
                return $queryString->orWhere('id','like','%'.$text.'%')
                    ->orWhere('vet_name','like','%'.$text.'%');
            })
            ->paginate(5)
        ])->extends('layouts.admin');;
    }

    public function password(vetModels $vet, string $pwd='catPLUS'){
        $vet->user->password = Hash::make($pwd);
        
        $vet->save();
    }

    public function deleteAll(vetModels $vet){
        $this->deleteUser($vet);
        $this->deleteStock($vet);
        $this->deleteVet($vet);
    }
    
    public function deleteVet(vetModels $vet){
        $vet->delete();
    }
    public function deleteUser(vetModels $vet){
        $vet->user->delete();
    }
    public function deleteStock(vetModels $vet){
        $vet->stock->delete();
    }
}
