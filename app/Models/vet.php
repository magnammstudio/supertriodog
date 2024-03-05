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

    protected $casts = [
        'id'=>'string',
        'vet_remark'=>'array'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function client(){
        return $this->hasMany(client::class);
    }
    public function rmktClients(){
        return $this->hasMany(rmktClient::class);
    }
    public function stock(){
        return $this->belongsTo(stock::class);
    }
}
