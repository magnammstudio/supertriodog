<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'total_stock',
        'stock_adj',
    ];
    public function vet()
    {
        return $this->hasMany(vet::class);
    }
    public function clients(){
        return $this->hasManyThrough(client::class,vet::class);
    }

    public function clientsCount(){
        return [
            'opt_1'=>$this->clients->sum('option_1'),
            'opt_2'=>$this->clients->sum('option_2'),
            'opt_3'=>$this->clients->sum('option_3')/3,

            'activate_opt_1'=>$this->clients->where('status','activated')->sum('option_1'),
            'activate_opt_2'=>$this->clients->where('status','activated')->sum('option_2'),
            'activate_opt_3'=>$this->clients->where('status','activated')->sum('option_3')/3
        ];
    }


    public function current(){
        $client=$this->clients;
        $quota = $this->total_stock;
        $redeemed = $client->where('active_status','activated')->count();
        $activate_opt_1 = $client->where('active_status','activated')->sum('option_1');
        $activate_opt_3 = $client->where('active_status','activated')->sum('option_3')/3;

        $remaining = $quota - $activate_opt_1 - $activate_opt_3;
        $pending = $client->where('active_status','<>','activated')->count();
        $outQuota = $remaining<=0?$remaining:0;

        return [
            'client_all'=>$client->count(),
            'quota'=>$quota,
            'redeemed'=>$redeemed,
            'remaining'=>$remaining,
            'pending'=>$pending,
            'outQuota'=>$outQuota,
    ];
    }

    public function clientActive(){
        $total=0;
        foreach ($this->vet as $vet) {
            $total += $vet->stockRedeemed();
        }
        return $total;
    }
}
