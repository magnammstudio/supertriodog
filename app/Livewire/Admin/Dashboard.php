<?php

namespace App\Livewire\Admin;

use App\Models\client as clientModel;
use App\Models\vet;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    public $search;
    protected $queryString = ['search'];
    public $static;
    public $vets;
    
    use WithPagination;

    public function mount(){
        $client=clientModel::all();
        $this->static=[
            'client'=>$client->count(),
            'client_activated'=>$client->countBy('active_status')['activated'],
            'client_pending'=>$client->countBy('active_status')['pending'],
            'client_option_1'=>$client->count('option_1'),
            'client_option_2'=>$client->count('option_2'),
            'client_option_3'=>$client->count('option_3'),
        ];
        // dd($this->static);
        $this->vets=vet::with('stock')->get();

        $this->search=[
            'text'=>null,
            'status'=>null,
            'paginate'=>25
        ];
    }
    public function render()
    {
        // dd(clientModel::with('vet')->whereHas('vet',function($query){
        //     $query->where('vet_name','เอกภพรักษาสัตว์');
        // })->get()
        // ,vet::where('vet_name','เอกภพรักษาสัตว์')->get()
        // );
        return view('livewire.admin.dashboard',[
            'clients'=>clientModel::with('vet')
            ->when($this->search['text']!=null,function($queryString){
                // dd($queryString->get());
                $text = $this->search['text'];
                // dd($text);
                return $queryString->where('name','like','%'.$text.'%')
                    ->orWhere('vet_id','like','%'.$text.'%')
                    ->orWhere('phone','like','%'.$text.'%');
            })
            ->when($this->search['status']!=null,function($queryString){
                $text = $this->search['status'];
                return $queryString->where('active_status',$text);
            })->orderBy('updated_at','DESC')
            ->paginate($this->search['paginate'])
        ])->extends('layouts.admin');
    }
}
