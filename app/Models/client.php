<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_code',
        'name',
        'email',
        'phone',
        'phoneIsVerified',
        'otp_token',
        'password',

        'pet_name',
        'pet_breed',
        'pet_weight',
        'pet_age_month',
        'pet_age_year',
        'option_1',
        'option_2',
        'option_3',

        'vet_id',
        'active_date',
        'active_status',
        'remark'
    ];

    protected $casts = [
        'remark' => 'array',
        'vet_id' => 'string',
    ];
    public function vet(){
        return $this->belongsTo(vet::class);
    }

    public function rmkt(){
        return $this->hasMany(rmktClient::class);
    }

    public function profile(){
        // dd($this->rmkt->);
        // $client = $this->withCount(
        //     [
        //         'rmkt',
        //         'rmkt as rmkt_active'=>function($query){
        //             $query->where('active_status','activated');
        //         },
        //         'rmkt as rmkt_opt1'=>function($query){
        //             $query->whereNotNull('option_1');
        //         },
        //         'rmkt as rmkt_opt2'=>function($query){
        //             $query->whereNotNull('option_2');
        //         },
        //         'rmkt as rmkt_opt3'=>function($query){
        //             $query->whereNotNull('option_3');
        //         }
        //     ]
        // )->get();

        // dd($client);

    }
}
