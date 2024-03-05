<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rmktClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'vet_id',
        'option_1',
        'option_2',
        'option_3',
        'active_date',
        'active_status',
        'remark'
    ];

    public function profile()
    {
        return $this->belongsTo(client::class,'client_id','id');
    }
    public function vet()
    {
        return $this->belongsTo(vet::class);
    }
}
