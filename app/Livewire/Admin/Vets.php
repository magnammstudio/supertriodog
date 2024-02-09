<?php

namespace App\Livewire\Admin;

use App\Models\vet;
use Livewire\Component;

use Livewire\WithPagination;

class Vets extends Component
{
    use WithPagination;
    public $search;
    public $stock;
    // public $vets;
    public function mount(){
        $this->stock = vet::with('stock')->get();

        $this->search=[
            'text'=>null,
            'status'=>null,
            'paginate'=>50
        ];
    }
    public function render()
    {
        return view('livewire.admin.vets',[
            'vets'=>vet::with('stock')
            ->when($this->search['text']!=null,function($queryString){
                $text = $this->search['text'];
                return $queryString->where('vet_name','like','%'.$text.'%')
                    ->orWhere('vet_province','like','%'.$text.'%')
                    ->orWhere('vet_city','like','%'.$text.'%')
                    ->orWhere('vet_area','like','%'.$text.'%')
                    ->orWhere('id','like','%'.$text.'%')
                    ->orWhere('stock_id','like','%'.$text.'%');
            })->orderBy('updated_at','DESC')->paginate($this->search['paginate'])
        ])->extends('layouts.admin');
    }
}
