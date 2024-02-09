<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vet extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'vet_name',
        'vet_province',
        'vet_city',
        'vet_area',
        'user_id',
        'stock_id',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
    public function client(){
        return $this->hasMany(Client::class);
    }
    public function stock()
    {
        return $this->belongsTo(stock::class);
    }

    public function stockRemaining(){
        return $this->stock->total_stock- $this->withCurrentStock()->sum('opt_1_act');
    }
    public function withCurrentStock(){
        $vet = $this->withCount([
            'client as client_all',
            'client as opt_1_act' =>function( $query){
                $query->where('option_1', 1)->where('active_status','activated');
            },
            'client as opt_1' =>function( $query){
                $query->where('option_1', 1);
            },
            'client as opt_2' =>function( $query){
                $query->where('option_2', 1);
            },
            'client as opt_3' =>function( $query){
                $query->where('option_3','>=', 1);
            },
            'client as c_activated' =>function( $query){
                $query->where('active_status','activated');
            },
            'client as c_pending' =>function( $query){
                $query->whereNot('active_status','activated');
            }
        ])->where('stock_id',$this->stock_id)->get();
        
        return $vet;
    }
    public function stockRedeemed(){
        $opt1= $this->client->where('option_1')->where('active_status','activated')->count();
        
        return $opt1;
    }
}
