<?php

namespace App\Livewire\Admin;

use App\Models\client as clientModel;
use App\Models\vet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    public $search=[
        'text'=>null,
        'status'=>null,
        'paginate'=>25
    ];
    public $static;
    public $vets;
    
    protected $queryString = [
        'search.text'=> ['except' => '','as'=>'q'],
        'search.status'=> ['except' => '','as'=>'s'],
        'search.paginate'=> ['except' => 25,'as'=>'p']
    ];

    use WithPagination;

    public function mount(){
        if(!Auth::user()->isAdmin){
            return redirect()->route('admin.vet' ,Auth::user()->id);
        }
        $client=clientModel::all();
        $this->static=[
            'client'=>$client->count(),
            'client_activated'=>$client->countBy('active_status')['activated']??0,
            'client_pending'=>$client->countBy('active_status')['pending']??0,
            'client_option_1'=>$client->where('option_1')->count(),
            'client_option_2'=>$client->where('option_2')->count(),
            'client_option_3'=>$client->where('option_3')->count(),
        ];
        // dd($this->static);
        $this->vets=vet::with('stock')->get();
    }
    public function render(){
        return view('livewire.admin.dashboard',[
            'clients'=>clientModel::with('vet')
                ->when($this->search['text']!=null,function($queryString){
                    // dd($queryString->get());
                    $text = $this->search['text'];
                    // dd($text);
                    return $queryString->orWhere('name','like','%'.$text.'%')
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
    public function updatingSearch(){
        $this->resetPage();
    }
    public function delete (clientModel $client){
        $client->delete();
    }
}
