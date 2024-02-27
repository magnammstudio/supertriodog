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
    public function vet(){
        return $this->hasMany(vet::class);
    }
    public function clients(){
        return $this->hasManyThrough(client::class,vet::class);
    }

    public function current(){
        $client=$this->clients;
        $quota = $this->total_stock;
        $redeemed = $client->where('active_status','activated')->count();
        $activate_opt_1 = $client->where('active_status','activated')->where('option_1')->count();
        $activate_opt_3 = $client->where('active_status','activated')->where('option_3')->count();

        $opt_1 = $client->where('active_status','activated')->where('option_1')->count();
        $opt_3 = $client->where('active_status','activated')->where('option_3')->count();

        $remaining = $quota - $activate_opt_1 - $activate_opt_3;
        $pending = $client->where('active_status','<>','activated')->count();
        $outQuota = (($quota - $opt_1 - $opt_3)<=0)?($opt_1 - $opt_3):0;

        return [
            'client_all'=>$client->count(),
            'quota'=>$quota,
            'redeemed'=>$redeemed,
            'remaining'=>$remaining,
            'pending'=>$pending,
            'outQuota'=>$outQuota,
        ];
    }

}
