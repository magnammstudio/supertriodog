<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\vet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class downloads extends Controller
{
    //
    public function client(){
        // dd('download');

        $now = Carbon::now()->toDateTimeString();
        // dd($now);
        $fileName = 'client '.$now.'.csv';
        $Clients = client::all();
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
    
        $columns = array('code', 'name', 'email', 'phone', 'status', 'activate date','vet id', 'vet name' ,'Pet name', 'Pet bread', 'Pet Weight', 'Pet Age','option 1','option 2','option 3','create at','update at');
    
        $callback = function() use($Clients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach ($Clients as $Client) {
                $row['code']  = $Client->client_code;
                $row['name']    = $Client->name;
                $row['email']    = $Client->email;
                $row['phone']  = $Client->phone;
                $row['status']  = $Client->active_status;
                $row['activate_date']  = $Client->active_date??"-";
                $row['created_at']  = $Client->created_at??"-";
                $row['updated_at']  = $Client->updated_at??"-";
                $row['vet']  = vet::find($Client->vet_id)->vet_name??$Client->vet_id;
                $row['vet_id']  = $Client->vet_id;
                
                $row['option 1']  = $Client->option_1??0;
                $row['option 2']  = $Client->option_2??0;
                $row['option 3']  = $Client->option_3??0;
    
                $row['petName']  = $Client->pet_name;
                $row['petBreed']  = $Client->pet_breed;
                $row['petWeight']  = $Client->pet_weight;
                $row['petAge']  = $Client->pet_age_month.' Year '.$Client->pet_age_month.' Month';
    
                fputcsv($file, array($row['code'], $row['name'], $row['email'], $row['phone'], $row['status'], $row['activate_date'], $row['vet_id'], $row['vet'], $row['petName'],$row['petBreed'],$row['petWeight'],$row['petAge'],$row['option 1'],$row['option 2'],$row['option 3'],$row['created_at'],$row['updated_at']));
            }
    
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
